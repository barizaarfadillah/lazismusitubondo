<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Donasi;
use App\Models\Artikel;

class BerandaController extends Controller
{
    public function landing()
    {
        // Ambil data statistik
        $totalPrograms = Program::where('status', 'Aktif')->count();
        $totalDonatur  = Donasi::where('status', 'Berhasil')->distinct('id_user')->count();
        $totalDana     = Donasi::where('status', 'Berhasil')->sum('nominal');

        // Ambil 3 program terbaru/pilihan untuk ditampilkan di Beranda
        $featuredPrograms = Program::where('status', 'Aktif')
            ->with('kategori')
            ->withSum(['donasi as donasi_terkumpul' => function($q) {
                $q->where('status', 'Berhasil');
            }], 'nominal')
            ->get();
            
        $artikels = Artikel::where('status', 'Publish')->latest()->take(3)->get();

        return view('landing', compact('totalPrograms', 'totalDonatur', 'totalDana', 'featuredPrograms', 'artikels'));
    }

    public function tentang()
    {
        return view('tentang');
    }
}
