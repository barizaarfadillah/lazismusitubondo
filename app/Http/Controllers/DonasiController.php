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
}