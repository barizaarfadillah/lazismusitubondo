<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanDonasiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data untuk dropdown filter
        $programs = Program::orderBy('nama_program', 'asc')->get();
        $donaturs = User::where('is_admin', 0)->orderBy('nama', 'asc')->get();

        // Tangkap input filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $programId = $request->input('program_id');
        $donaturId = $request->input('donatur_id');

        // Query dasar (Hanya donasi yang berhasil)
        $query = Donasi::with(['user', 'program', 'rekening'])->where('status', 'Berhasil');

        // Filter Rentang Tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        // Filter Program
        if ($programId) {
            $query->where('id_program', $programId); // Sesuaikan id_program jika berbeda
        }

        // Filter Donatur
        if ($donaturId) {
            $query->where('id_user', $donaturId);
        }

        // Hitung Ringkasan (Summary) sebelum di-paginate
        $totalNominal = $query->sum('nominal');
        $totalTransaksi = $query->count();

        // Eksekusi data dengan pagination
        $reports = $query->latest()->paginate(20);

        return view('admin.laporan.index', compact(
            'reports', 'programs', 'donaturs', 'totalNominal', 'totalTransaksi',
            'startDate', 'endDate', 'programId', 'donaturId'
        ));
    }

    public function cetak(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $programId = $request->input('program_id');
        $donaturId = $request->input('donatur_id');

        $query = Donasi::with(['user', 'program', 'rekening'])->where('status', 'berhasil');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        if ($programId) {
            $query->where('id_program', $programId);
        }

        if ($donaturId) {
            $query->where('id_user', $donaturId);
        }

        $totalNominal = $query->sum('nominal');
        
        // Ambil SEMUA data yang sesuai filter (tidak pakai paginate)
        // Menggunakan oldest() agar urutan tanggal dari yang terlama ke terbaru (standar laporan)
        $reports = $query->oldest()->get(); 

        return view('admin.laporan.cetak', compact(
            'reports', 'totalNominal', 'startDate', 'endDate'
        ));
    }
}