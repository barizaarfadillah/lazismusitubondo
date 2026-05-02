<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donasi;

class DonaturController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Donatur (Ringkasan)
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Menghitung total uang dari donasi yang statusnya 'Berhasil'
        // Catatan: Gunakan sum('nominal') atau sum('jumlah') sesuai dengan nama kolom di database Anda
        $totalDonasi = Donasi::where('id_user', $userId)
                             ->where('status', 'Berhasil')
                             ->sum('nominal'); 

        // 2. Menghitung total program (unik) yang berhasil didonasikan
        $totalProgram = Donasi::where('id_user', $userId)
                              ->where('status', 'Berhasil')
                              ->distinct('id_program') // Menghitung ID program agar tidak dobel
                              ->count('id_program');

        return view('donatur.dashboard', compact('totalDonasi', 'totalProgram'));
    }

    /**
     * Menampilkan halaman Riwayat / Donasi Saya
     */
    public function riwayat(Request $request)
    {
        // 1. Tangkap parameter status dari URL (default: menunggu)
        $statusTab = $request->query('status', 'menunggu');

        // 2. Siapkan query dasar: Ambil donasi milik user yang login, urutkan dari terbaru
        // Pastikan relasi 'program' sudah ada di model Donasi agar tidak N+1 Query
        $query = Donasi::with('program')->where('id_user', Auth::id())->latest();

        // 3. Filter berdasarkan tab yang dipilih
        if ($statusTab == 'menunggu') {
            $query->where('status', 'Pending'); 
        } elseif ($statusTab == 'berhasil') {
            $query->where('status', 'Berhasil');
        } elseif ($statusTab == 'gagal') {
            $query->where('status', 'Gagal'); // Sesuaikan dengan enum di database Anda ('Gagal' atau 'Ditolak')
        }

        // 4. Eksekusi query
        $riwayatDonasi = $query->get();

        // 5. Kirim data ke view
        return view('donatur.riwayat', compact('riwayatDonasi', 'statusTab'));
    }

    public function show($kode_transaksi)
    {
        $donasi = Donasi::with(['program', 'rekening'])
                    ->where('id_user', auth()->id())
                    ->where('kode_transaksi', $kode_transaksi) // Cari berdasarkan kode transaksi
                    ->firstOrFail();

        return view('donatur.riwayat-detail', compact('donasi'));
    }

    public function kuitansi($kode_transaksi)
    {
        $donasi = Donasi::with(['program', 'rekening'])
                    ->where('id_user', auth()->id())
                    ->where('kode_transaksi', $kode_transaksi) // Cari berdasarkan kode transaksi
                    ->where('status', 'Berhasil')
                    ->firstOrFail();

        return view('donatur.kuitansi', compact('donasi'));
    }

    /**
     * Menampilkan halaman Setting Profil
     */
    public function profil()
    {
        // Pastikan Anda sudah membuat file view: resources/views/donatur/profil.blade.php
        return view('donatur.profil');
    }
}