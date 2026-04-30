<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        $categories = Kategori::all();

        $query = Program::with(['kategori'])
            ->withSum(['donasi as donasi_terkumpul' => function($q) {
                $q->where('status', 'Berhasil');
            }], 'nominal')
            // Menambahkan hitungan jumlah donatur yang berhasil
            ->withCount(['donasi as jumlah_donatur' => function($q) {
                $q->where('status', 'Berhasil');
            }]);

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        $programs = $query->latest()->get();

        return view('donasi.index', compact('programs', 'categories'));
    }

    public function show($slug)
    {
        $program = Program::with(['kategori', 'kabar_program' => function($q) {
                $q->latest();
            }])
            ->withSum(['donasi as donasi_terkumpul' => function($q) {
                $q->where('status', 'Berhasil');
            }], 'nominal')
            ->withCount(['donasi as jumlah_donatur' => function($q) {
                $q->where('status', 'Berhasil');
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        // Ambil daftar donatur terbaru yang berhasil
        $donaturList = $program->donasi()
            ->where('status', 'Berhasil')
            ->latest()
            ->take(10)
            ->get();

        return view('donasi.show', compact('program', 'donaturList'));
    }
}