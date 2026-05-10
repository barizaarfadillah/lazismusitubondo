<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;

class VerifikasiDonasiController extends Controller
{
    /**
     * Menampilkan daftar transaksi berdasarkan tab status
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'pending'); // Default menampilkan tab pending

        // Ambil data donasi beserta relasi user dan programnya
        $query = Donasi::with(['user', 'program'])->where('status', $tab);

        // Fitur Pencarian (berdasarkan nama donatur atau nama program)
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('program', function($q) use ($search) {
                $q->where('nama_program', 'like', "%{$search}%");
            });
        }

        $donasis = $query->latest()->paginate(10);

        return view('admin.verifikasi.index', compact('donasis', 'search', 'tab'));
    }

    /**
     * Menampilkan detail donasi
     */
    public function show($id)
    {
        // Sesuaikan 'id_donasi' dengan nama primary key di tabel donasi Anda
        $donasi = Donasi::with(['user', 'program', 'rekening'])->where('id_donasi', $id)->firstOrFail();
        
        return view('admin.verifikasi.show', compact('donasi'));
    }

    /**
     * Mengubah status menjadi Berhasil
     */
    public function terima($id)
    {
        $donasi = Donasi::where('id_donasi', $id)->firstOrFail();
        $donasi->update(['status' => 'Berhasil']);

        // Ubah redirect agar kembali ke halaman detail (show)
        return redirect()->route('admin.verifikasi.show', $id)
                         ->with('success', 'Alhamdulillah, donasi berhasil diverifikasi. Silakan kirim Kuitansi ke donatur!');
    }

    /**
     * Mengubah status menjadi Gagal
     */
    public function tolak($id)
    {
        $donasi = Donasi::where('id_donasi', $id)->firstOrFail();
        $donasi->update(['status' => 'Gagal']);

        return redirect()->route('admin.verifikasi.index', ['tab' => 'Gagal'])
                         ->with('success', 'Donasi telah ditolak / dibatalkan.');
    }
}