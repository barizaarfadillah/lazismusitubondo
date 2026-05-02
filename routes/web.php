<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RekeningController;
use App\Http\Controllers\Admin\KabarProgramController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\DonaturController; // <-- TAMBAHAN BARU: Memanggil DonaturController

// [PUBLIK] Katalog dan Detail: Bisa diakses siapa saja
Route::get('/', [DonasiController::class, 'index'])->name('donasi.index');
Route::get('/program/{slug}', [DonasiController::class, 'show'])->name('donasi.show');

// Kelompok rute untuk pengunjung yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Kelompok rute untuk pengguna yang SUDAH login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // [TRANSAKSI] Hanya bisa diakses jika sudah login
    Route::get('/program/{slug}/donasi', [DonasiController::class, 'create'])->name('donasi.create');
    Route::post('/program/{slug}/konfirmasi', [DonasiController::class, 'konfirmasi'])->name('donasi.konfirmasi');
    Route::post('/program/{slug}/donasi', [DonasiController::class, 'store'])->name('donasi.store');

    Route::get('/donasi/sukses/{id_donasi}', function ($id_donasi) {
        // Anda bisa membuat view donasi.sukses dan mengirimkan data donasinya
        $donasi = \App\Models\Donasi::with(['program', 'rekening'])
                    ->where('id_donasi', $id_donasi)
                    ->firstOrFail();
                    
        return view('donasi.sukses', compact('donasi'));
    })->name('donasi.sukses');

    // Kelompok rute khusus ADMIN
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::resource('rekening', RekeningController::class)->except(['show']);
        Route::resource('program', ProgramController::class);
        Route::resource('kabar-program', KabarProgramController::class)->except(['index', 'show']);
    });

    // --- REVISI: Kelompok rute khusus DONATUR ---
    Route::name('donatur.')->group(function () {
        Route::get('/dashboard', [DonaturController::class, 'index'])->name('dashboard');
        Route::get('/riwayat', [DonaturController::class, 'riwayat'])->name('riwayat');
        Route::get('/riwayat/{kode_transaksi}', [DonaturController::class, 'show'])->name('riwayat.detail');
        Route::get('/riwayat/{kode_transaksi}/kuitansi', [DonaturController::class, 'kuitansi'])->name('riwayat.kuitansi');
        Route::get('/profil', [DonaturController::class, 'profil'])->name('profil');
    });
});