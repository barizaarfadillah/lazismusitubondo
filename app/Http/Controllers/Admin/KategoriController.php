<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    /**
     * Menampilkan halaman daftar kategori.
     */
    public function index()
    {
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
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori', 
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori ini sudah terdaftar. Silakan gunakan nama lain.',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

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
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id . ',id_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah digunakan oleh kategori lain.',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus data kategori dari database dengan penanganan relasi.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // 1. Cek manual apakah kategori ini masih memiliki program terkait
        // Pastikan Anda sudah mendefinisikan relasi 'program' di model Kategori
        if ($kategori->program()->exists()) {
            return redirect()->route('kategori.index')->withErrors([
                'error' => 'Gagal menghapus! Kategori "' . $kategori->nama_kategori . '" masih memiliki ' . $kategori->program()->count() . ' program donasi aktif. Silakan hapus atau pindahkan program tersebut terlebih dahulu.'
            ]);
        }

        try {
            // 2. Jika tidak ada relasi, baru jalankan fungsi hapus
            $kategori->delete();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')->withErrors([
                'error' => 'Terjadi kesalahan sistem saat mencoba menghapus kategori.'
            ]);
        }
    }
}