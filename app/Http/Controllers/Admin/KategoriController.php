<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori; // Pastikan Model Kategori sudah di-import

class KategoriController extends Controller
{
    /**
     * Menampilkan halaman daftar kategori.
     */
    public function index()
    {
        // Mengambil semua data kategori dari database
        $kategori = Kategori::all(); 
        
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            // Asumsi nama tabel di database adalah 'kategori'
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori', 
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Kategori ini sudah terdaftar. Silakan gunakan nama lain.',
        ]);

        // 2. Simpan ke database
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // Validasi unik, namun abaikan ID kategori yang sedang diedit saat ini
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id . ',id_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Kategori ini sudah terdaftar.',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus data kategori dari database.
     */
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID, lalu hapus
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}