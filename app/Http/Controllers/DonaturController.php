<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Donasi;

class DonaturController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Donatur (Ringkasan)
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Menghitung total uang dari donasi yang statusnya 'Berhasil'
        $totalDonasi = Donasi::where('id_user', $userId)
                             ->where('status', 'Berhasil')
                             ->sum('nominal'); 

        // 2. Menghitung total program (unik) yang berhasil didonasikan
        $totalProgram = Donasi::where('id_user', $userId)
                              ->where('status', 'Berhasil')
                              ->distinct('id_program') 
                              ->count('id_program');

        // 3. Donasi Terakhir
        $donasiTerakhir = Donasi::with('program')
                              ->where('id_user', $userId)
                              ->where('status', 'Berhasil')
                              ->latest('created_at')
                              ->first();

        // 4. Kategori Favorit
        $kategoriFavorit = DB::table('donasi')
            ->join('program', 'donasi.id_program', '=', 'program.id_program')
            ->join('kategori', 'program.id_kategori', '=', 'kategori.id_kategori')
            ->where('donasi.id_user', $userId)
            ->where('donasi.status', 'Berhasil')
            ->select('kategori.nama_kategori', DB::raw('COUNT(donasi.id_donasi) as total_bantu'))
            ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
            ->orderByDesc('total_bantu')
            ->first();

        // 5. Mengambil Kabar Program terbaru dari program yang pernah diikuti
        // Kita ambil ID program yang pernah didonasikan secara berhasil
        $programIds = Donasi::where('id_user', $userId)
                            ->where('status', 'Berhasil')
                            ->pluck('id_program');

        // Ambil 3 kabar program terbaru dari program-program tersebut
        // Asumsi: Anda memiliki model KabarProgram yang berelasi dengan Program
        $kabarTerbaru = \App\Models\KabarProgram::with('program')
                            ->whereIn('id_program', $programIds)
                            ->latest()
                            ->take(3)
                            ->get();

        // 3. STATISTIK GRAFIK (6 Bulan Terakhir)
        $chartLabels = [];
        $chartData = [];

        // Looping 6 bulan ke belakang
        for ($i = 5; $i >= 0; $i--) {
            $bulanIni = now()->subMonths($i);
            
            // Format label: "Jan 2026", "Feb 2026", dll
            $chartLabels[] = $bulanIni->translatedFormat('M Y'); 

            // Hitung total donasi di bulan & tahun tersebut
            $totalBulanIni = Donasi::where('id_user', $userId)
                ->where('status', 'Berhasil')
                ->whereMonth('created_at', $bulanIni->month)
                ->whereYear('created_at', $bulanIni->year)
                ->sum('nominal');
                
            $chartData[] = $totalBulanIni;
        }

        return view('donatur.dashboard', compact(
            'totalDonasi', 'totalProgram', 'donasiTerakhir', 'kategoriFavorit', 'kabarTerbaru', 'chartLabels', 'chartData'
        ));
    }

    /**
     * Menampilkan halaman Riwayat / Donasi Saya
     */
    public function riwayat(Request $request)
    {
        // 1. Tangkap parameter status dari URL (default: menunggu)
        $statusTab = $request->query('status', 'menunggu');

        // 2. Siapkan query dasar: Ambil donasi milik user yang login, urutkan dari terbaru
        // Pastikan relasi 'program' sudah ada di model Donasi agar tidak N+1 Query
        $query = Donasi::with('program')->where('id_user', Auth::id())->latest();

        // 3. Filter berdasarkan tab yang dipilih
        if ($statusTab == 'menunggu') {
            $query->where('status', 'Pending'); 
        } elseif ($statusTab == 'berhasil') {
            $query->where('status', 'Berhasil');
        } elseif ($statusTab == 'gagal') {
            $query->where('status', 'Gagal'); // Sesuaikan dengan enum di database Anda ('Gagal' atau 'Ditolak')
        }

        // 4. Eksekusi query
        $riwayatDonasi = $query->get();

        // 5. Kirim data ke view
        return view('donatur.riwayat', compact('riwayatDonasi', 'statusTab'));
    }

    public function show($kode_transaksi)
    {
        $donasi = Donasi::with(['program', 'rekening'])
                    ->where('id_user', auth()->id())
                    ->where('kode_transaksi', $kode_transaksi) // Cari berdasarkan kode transaksi
                    ->firstOrFail();

        return view('donatur.riwayat-detail', compact('donasi'));
    }

    public function kuitansi($kode_transaksi)
    {
        $donasi = Donasi::with(['program', 'rekening'])
                    ->where('id_user', auth()->id())
                    ->where('kode_transaksi', $kode_transaksi) // Cari berdasarkan kode transaksi
                    ->where('status', 'Berhasil')
                    ->firstOrFail();

        return view('donatur.kuitansi', compact('donasi'));
    }

    /**
     * Menampilkan halaman Setting Profil
     */
    public function profil()
    {
        $user = auth()->user();
    
        return view('donatur.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        // Validasi input data
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:user,email,'.$user->id_user.',id_user',
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data ke database
        $dataUpdate = [
            'nama'     => $request->nama,
            'email'    => $request->email,
            'no_telp'  => $request->no_telp,
            'alamat'   => $request->alamat,
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = bcrypt($request->password);
        }

        $user->update($dataUpdate);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('donatur.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}