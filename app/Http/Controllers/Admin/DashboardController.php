<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // 1. KARTU RINGKASAN (QUICK STATS)
        $pendingDonasi = Donasi::where('status', 'pending')->count();
        
        $danaBulanIni = Donasi::where('status', 'berhasil')
                              ->whereMonth('created_at', $now->month)
                              ->whereYear('created_at', $now->year)
                              ->sum('nominal');
                              
        $totalDonatur = User::where('is_admin', 0)->count();
        $programAktif = Program::count(); // Sesuaikan jika ada kolom status di tabel program

        // 2. DATA GRAFIK (Total Donasi Berhasil per Bulan di Tahun Ini)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = Donasi::where('status', 'berhasil')
                                 ->whereYear('created_at', $now->year)
                                 ->whereMonth('created_at', $i)
                                 ->sum('nominal');
        }

        // 3. TABEL AKSI CEPAT (5 Donasi Pending Terbaru)
        $latestPending = Donasi::with(['user', 'program'])
                               ->where('status', 'pending')
                               ->latest()
                               ->take(5)
                               ->get();

        // 4. RASIO KEBERHASILAN (Success Rate)
        $totalSemuaTransaksi = Donasi::count();
        $transaksiBerhasil = Donasi::where('status', 'berhasil')->count();
        $successRate = $totalSemuaTransaksi > 0 ? round(($transaksiBerhasil / $totalSemuaTransaksi) * 100, 1) : 0;

        // 5. TOP 5 PROGRAM (Leaderboard berdasarkan nominal masuk)
        $topPrograms = Program::withSum(['donasi' => function($query) {
            $query->where('status', 'berhasil');
        }], 'nominal')
        ->orderBy('donasi_sum_nominal', 'desc')
        ->take(5)
        ->get();

        // 6. PROGRAM HAMPIR BERAKHIR (Deadline < 7 Hari)
        $urgentPrograms = Program::whereNotNull('tenggat_waktu') // Asumsi nama kolom tgl_selesai
            ->whereBetween('tenggat_waktu', [Carbon::now(), Carbon::now()->addDays(7)])
            ->get();

        // 7. TOP 5 DONATUR (Berdasarkan akumulasi donasi berhasil)
        $topDonors = User::where('is_admin', 0)
            ->withSum(['donasi' => function($query) {
                $query->where('status', 'berhasil');
            }], 'nominal')
            ->orderBy('donasi_sum_nominal', 'desc')
            ->take(5)
            ->get();

        // Masukkan ke dalam compact()
        return view('admin.dashboard', compact(
            'pendingDonasi', 'danaBulanIni', 'totalDonatur', 'programAktif', 
            'chartData', 'latestPending', 'successRate', 'topPrograms',
            'urgentPrograms', 'topDonors'
        ));
    }

    /**
     * Menampilkan halaman profil admin.
     */
    public function profil()
    {
        $user = auth()->user();
        return view('admin.profil', compact('user'));
    }

    /**
     * Memperbarui data profil admin.
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:user,email,'.$user->id_user.',id_user',
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $dataUpdate = [
            'nama'    => $request->nama,
            'email'   => $request->email,
            'no_telp' => $request->no_telp,
            'alamat'  => $request->alamat,
        ];

        // Jika password diisi, lakukan enkripsi
        if ($request->filled('password')) {
            $dataUpdate['password'] = bcrypt($request->password);
        }
        
        $user->update($dataUpdate);

        return redirect()->route('admin.profil')->with('success', 'Profil admin berhasil diperbarui!');
    }
}