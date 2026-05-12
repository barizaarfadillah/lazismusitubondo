<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar semua artikel untuk pengunjung
     */
    public function index(Request $request)
    {
        $query = Artikel::where('status', 'Publish')->latest();

        // Fitur Pencarian (Opsional, tapi sangat berguna)
        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Fitur Filter Kategori (Opsional)
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $artikels = $query->paginate(9); // 9 artikel per halaman
        
        return view('artikel.index', compact('artikels'));
    }

    /**
     * Menampilkan isi lengkap satu artikel
     */
    public function show($slug)
    {
        // Mencari artikel berdasarkan slug yang aktif
        $artikel = Artikel::where('slug', $slug)
            ->where('status', 'Publish')
            ->firstOrFail();

        // Menambah jumlah klik/view setiap kali halaman dibuka
        $artikel->increment('views');

        // Mengambil 3 artikel terbaru lainnya sebagai rekomendasi bacaan
        $relatedArtikels = Artikel::where('status', 'Publish')
            ->where('id_artikel', '!=', $artikel->id_artikel)
            ->latest()
            ->take(3)
            ->get();

        return view('artikel.show', compact('artikel', 'relatedArtikels'));
    }
}