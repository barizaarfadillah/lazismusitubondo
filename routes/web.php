<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RekeningController;
use App\Http\Controllers\Admin\KabarProgramController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaDonaturController;
use App\Http\Controllers\Admin\KelolaAdminController;
use App\Http\Controllers\Admin\VerifikasiDonasiController;
use App\Http\Controllers\Admin\LaporanDonasiController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\DonaturController;

// Rute untuk pengunjung yang BELUM login
Route::middleware('guest')->group(function () {

    // Rute Katalog dan Detail Program
    Route::get('/', [DonasiController::class, 'index'])->name('donasi.index');
    Route::get('/program/{slug}', [DonasiController::class, 'show'])->name('donasi.show');

    // Rute login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Rute register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Rute untuk pengguna yang SUDAH login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // [TRANSAKSI] Hanya bisa diakses jika sudah login
    Route::get('/program/{slug}/donasi', [DonasiController::class, 'create'])->name('donasi.create');
    Route::post('/program/{slug}/konfirmasi', [DonasiController::class, 'konfirmasi'])->name('donasi.konfirmasi');
    Route::post('/program/{slug}/donasi', [DonasiController::class, 'store'])->name('donasi.store');
    Route::get('/donasi/sukses/{id_donasi}', function ($id_donasi) {
        $donasi = \App\Models\Donasi::with(['program', 'rekening'])
                    ->where('id_donasi', $id_donasi)
                    ->firstOrFail();
        return view('donasi.sukses', compact('donasi'));
    })->name('donasi.sukses');

    // Rute khusus ADMIN
    Route::middleware('admin')->prefix('admin')->group(function () {
        
        // Rute dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Rute kelola kategori
        Route::resource('kategori', KategoriController::class)->except(['show']);

        // Rute kelola rekening
        Route::resource('rekening', RekeningController::class)->except(['show']);

        // Rute kelola program
        Route::resource('program', ProgramController::class);
        Route::resource('kabar-program', KabarProgramController::class)->except(['index', 'show']);

        // Rute kelola profil
        Route::get('/profil', [DashboardController::class, 'profil'])->name('admin.profil');
        Route::patch('/profil/update', [DashboardController::class, 'updateProfil'])->name('admin.profil.update');

        // Rute kelola donatur
        Route::get('/donatur', [KelolaDonaturController::class, 'index'])->name('admin.donatur.index');
        Route::get('/donatur/create', [KelolaDonaturController::class, 'create'])->name('admin.donatur.create');
        Route::post('/donatur', [KelolaDonaturController::class, 'store'])->name('admin.donatur.store');
        Route::get('/donatur/{id}', [KelolaDonaturController::class, 'show'])->name('admin.donatur.show');
        Route::get('/donatur/{id}/edit', [KelolaDonaturController::class, 'edit'])->name('admin.donatur.edit');
        Route::put('/donatur/{id}', [KelolaDonaturController::class, 'update'])->name('admin.donatur.update');
        Route::delete('/donatur/{id}', [KelolaDonaturController::class, 'destroy'])->name('admin.donatur.destroy');
        Route::post('/donatur/{id}/aktifkan', [KelolaDonaturController::class, 'aktifkan'])->name('admin.donatur.aktifkan');

        // Rute kelola admin
        Route::get('/admin', [KelolaAdminController::class, 'index'])->name('admin.admin.index');
        Route::get('/admin/create', [KelolaAdminController::class, 'create'])->name('admin.admin.create');
        Route::post('/admin', [KelolaAdminController::class, 'store'])->name('admin.admin.store');
        Route::get('/admin/{id}/edit', [KelolaAdminController::class, 'edit'])->name('admin.admin.edit');
        Route::put('/admin/{id}', [KelolaAdminController::class, 'update'])->name('admin.admin.update');
        Route::delete('/admin/{id}', [KelolaAdminController::class, 'destroy'])->name('admin.admin.destroy');

        // Rute verifikasi donasi
        Route::get('/verifikasi-donasi', [VerifikasiDonasiController::class, 'index'])->name('admin.verifikasi.index');
        Route::get('/verifikasi-donasi/{id}', [VerifikasiDonasiController::class, 'show'])->name('admin.verifikasi.show');
        Route::put('/verifikasi-donasi/{id}/terima', [VerifikasiDonasiController::class, 'terima'])->name('admin.verifikasi.terima');
        Route::put('/verifikasi-donasi/{id}/tolak', [VerifikasiDonasiController::class, 'tolak'])->name('admin.verifikasi.tolak');

        // Rute laporan donasi
        Route::get('/laporan-donasi', [LaporanDonasiController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan-donasi/cetak', [LaporanDonasiController::class, 'cetak'])->name('admin.laporan.cetak');
    });

    // Rute khusus DONATUR
    Route::name('donatur.')->group(function () {

        // Rute dashboard donatur
        Route::get('/dashboard', [DonaturController::class, 'index'])->name('dashboard');

        // Rute riwayat donasi
        Route::get('/riwayat', [DonaturController::class, 'riwayat'])->name('riwayat');
        Route::get('/riwayat/{kode_transaksi}', [DonaturController::class, 'show'])->name('riwayat.detail');
        Route::get('/riwayat/{kode_transaksi}/kuitansi', [DonaturController::class, 'kuitansi'])->name('riwayat.kuitansi');

        // Rute kelola profil
        Route::get('/profil', [DonaturController::class, 'profil'])->name('profil');
        Route::patch('/profil/update', [DonaturController::class, 'updateProfil'])->name('profil.update');
    });
});