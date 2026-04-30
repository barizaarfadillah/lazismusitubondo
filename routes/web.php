<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RekeningController;
use App\Http\Controllers\Admin\KabarProgramController;

// --- TAMBAHAN SPRINT 2 ---
use App\Http\Controllers\DonasiController;

// Rute Publik: Halaman Utama sekarang menampilkan Katalog Program Donasi
Route::get('/', [DonasiController::class, 'index'])->name('donasi.index');
Route::get('/program/{slug}', [DonasiController::class, 'show'])->name('donasi.show');
// -------------------------

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

    // Kelompok rute khusus DONATUR (Akan kita rapikan di modul Dashboard Donatur nanti)
    Route::get('/donatur/dashboard', function () {
        return '
            <div style="text-align:center; margin-top:50px; font-family: sans-serif;">
                <h1 style="color:orange;">Selamat datang di Dashboard Donatur!</h1>
                <br><br>
                <form action="'.route('logout').'" method="POST">
                    '.csrf_field().'
                    <button type="submit" style="background-color:red; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">
                        Logout / Keluar
                    </button>
                </form>
            </div>
        ';
    });
});