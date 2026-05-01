<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Program;
use App\Models\Rekening;
use App\Models\Donasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    /**
     * Menampilkan katalog program donasi di halaman utama.
     */
    public function index(Request $request)
    {
        // 1. Siapkan query dasar
        $query = Program::with('kategori')
            ->withSum(['donasi as donasi_terkumpul' => function($q) {
                $q->where('status', 'Berhasil');
            }], 'nominal');

        // 2. Cek apakah ada filter 'kategori' di URL
        if ($request->has('kategori') && $request->kategori != '') {
            // Jika ada, filter program berdasarkan id_kategori tersebut
            $query->where('id_kategori', $request->kategori);
        }

        // 3. Eksekusi query (ambil datanya)
        $programs = $query->latest()->get();

        // 4. Ambil semua kategori untuk ditampilkan sebagai deretan tombol
        $categories = Kategori::all();

        return view('donasi.index', compact('programs', 'categories'));
    }

    /**
     * Menampilkan detail program berdasarkan slug.
     */
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

        // Mengambil daftar 10 donatur terbaru yang statusnya Berhasil
        $donaturList = $program->donasi()
            ->where('status', 'Berhasil')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('donasi.show', compact('program', 'donaturList'));
    }

    /**
     * Menampilkan form transaksi donasi.
     * Hanya bisa diakses jika sudah login (melalui middleware auth di routes).
     */
    public function create($slug)
    {
        // Ambil data program
        $program = Program::where('slug', $slug)->firstOrFail();
        
        // Gunakan ->get() secara eksplisit agar SELALU mengembalikan Collection (array), bukan null
        $rekening = $program->rekenings()->get(); 

        return view('donasi.create', compact('program', 'rekening'));
    }

    // 1. Menampilkan halaman konfirmasi sebelum disimpan
    public function konfirmasi(Request $request, $slug)
    {
        // Validasi inputan dari form donasi
        $request->validate([
            'nominal'     => 'required|numeric|min:10000',
            'id_rekening' => 'required|exists:rekening,id_rekening',
            'doa'         => 'nullable|string|max:500',
        ], [
            'nominal.min' => 'Mohon maaf, nominal donasi minimal adalah Rp 10.000',
            'id_rekening.required' => 'Silakan pilih salah satu metode pembayaran.'
        ]);

        $program = \App\Models\Program::where('slug', $slug)->firstOrFail();
        
        // Ambil data rekening yang dipilih
        $rekening = \App\Models\Rekening::findOrFail($request->id_rekening);
        
        // Simpan data ke dalam temporary array / session (atau langsung kirim ke view)
        $data_donasi = [
            'nominal'     => $request->nominal,
            'doa'         => $request->doa,
            'is_anonim'   => $request->has('is_anonim') ? 1 : 0,
        ];

        return view('donasi.konfirmasi', compact('program', 'rekening', 'data_donasi'));
    }

    // 2. Menyimpan data donasi setelah tombol konfirmasi ditekan
    public function store(Request $request, $slug)
    {
        // 1. Validasi Inputan
        $request->validate([
            'nominal'     => 'required|numeric|min:10000',
            'id_rekening' => 'required|exists:rekening,id_rekening',
        ]);

        $program = \App\Models\Program::where('slug', $slug)->firstOrFail();

        // 2. Buat nomor urut berdasarkan jumlah transaksi di tanggal hari ini
        $hariIni = date('Ymd');
        
        // Hitung jumlah donasi yang dibuat pada hari ini
        $jumlahHariIni = \App\Models\Donasi::whereDate('created_at', now()->format('Y-m-d'))->count();
        
        // Tambahkan 1 untuk nomor urut berikutnya
        $nomorUrut = $jumlahHariIni + 1;
        
        // Format menjadi 5 digit (contoh: 00001)
        $formattedNomor = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
        
        // Gabungkan menjadi format INV-Tanggal-NomorUrut
        $kodeTransaksi = 'INV-' . $hariIni . '-' . $formattedNomor;

        // 3. Simpan data donasi ke database
        $donasi = new \App\Models\Donasi();
        $donasi->kode_transaksi = $kodeTransaksi; 
        
        $donasi->id_program  = $program->id_program;
        $donasi->id_user     = auth()->user()->id_user; // Sesuaikan dengan primary key user Anda
        $donasi->id_rekening = $request->id_rekening;
        $donasi->nominal     = $request->nominal;
        $donasi->pesan_doa   = $request->doa;
        $donasi->is_anonim   = $request->is_anonim ? 1 : 0;
        $donasi->status      = 'Pending'; 
        
        $donasi->save();

        // 4. Arahkan kembali ke katalog dengan pesan sukses
        return redirect()->route('donasi.index')
                         ->with('donasi_berhasil', true);
    }
}