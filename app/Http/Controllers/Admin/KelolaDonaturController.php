<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaDonaturController extends Controller
{
    /**
     * Menampilkan daftar donatur (Aktif & Nonaktif) beserta fitur pencarian
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'aktif');

        // REVISI: Menggunakan is_admin = 0 untuk memfilter khusus donatur
        $query = User::where('is_admin', 0)->where('status_user', $tab);

        // Filter Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        $donaturs = $query->latest()->paginate(10);

        return view('admin.donatur.index', compact('donaturs', 'search', 'tab'));
    }

    /**
     * Menampilkan form tambah donatur
     */
    public function create()
    {
        return view('admin.donatur.create');
    }

    /**
     * Menyimpan data donatur baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'no_telp' => 'nullable|string|max:20',
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
        ]);

        User::create([
            'nama' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make('lazismu123'),
            
            // REVISI: Menggunakan is_admin = 0 untuk menandai sebagai donatur
            'is_admin' => 0, 
            'status_user' => 'Aktif'
        ]);

        return redirect()->route('admin.donatur.index')
                         ->with('success', 'Akun donatur berhasil dibuat dengan password default: lazismu123');
    }

    public function edit($id_user)
    {
        $donatur = User::findOrFail($id_user);
        return view('admin.donatur.edit', compact('donatur'));
    }

    /**
     * Menyimpan pembaruan data donatur
     */
    public function update(Request $request, $id_user)
    {
        $donatur = User::findOrFail($id_user);

        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi email: Abaikan pengecekan unique untuk ID donatur ini sendiri
            'email' => 'required|string|email|max:255|unique:user,email,' . $donatur->id_user. ',id_user',
            'no_telp' => 'nullable|string|max:20',
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
        ]);

        $donatur->update([
            'nama' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('admin.donatur.index')
                         ->with('success', 'Data donatur berhasil diperbarui.');
    }

    /**
     * Menghapus (Permanen) atau Menonaktifkan Donatur (2 Logika)
     */
    public function destroy($id_user)
    {
        $donatur = User::findOrFail($id_user);

        // Sekarang kita hitung jumlah donasi yang sebenarnya dari database
        $jumlahDonasi = Donasi::where('id_user', $id_user)->count();

        if ($jumlahDonasi == 0) {
            $donatur->delete();
            $pesan = 'Akun donatur berhasil dihapus permanen karena belum pernah melakukan donasi.';
        } else {
            // Jika sudah ada riwayat (berhasil/pending/gagal), cukup nonaktifkan
            $donatur->update(['status_user' => 'Nonaktif']);
            $pesan = 'Akun dinonaktifkan. Data tetap disimpan untuk keperluan audit laporan keuangan.';
        }

        return redirect()->route('admin.donatur.index')->with('success', $pesan);
    }

    /**
     * Mengaktifkan kembali akun yang nonaktif
     */
    public function aktifkan($id_user)
    {
        $donatur = User::findOrFail($id_user);
        $donatur->update(['status_user' => 'Aktif']);
        
        return redirect()->route('admin.donatur.index')
                         ->with('success', 'Akun donatur berhasil diaktifkan kembali.');
    }

    public function show($id_user)
    {
        // Mengambil data donatur beserta riwayat donasinya dan nama program terkait
        $donatur = User::with(['donasi.program'])->where('id_user', $id_user)->firstOrFail();
        
        $riwayatDonasi = $donatur->donasi()->latest()->get();

        return view('admin.donatur.show', compact('donatur', 'riwayatDonasi'));
    }
}