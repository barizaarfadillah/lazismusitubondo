<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekeningController extends Controller
{
    public function index()
    {
        $rekening = Rekening::all();
        return view('admin.rekening.index', compact('rekening'));
    }

    public function create()
    {
        return view('admin.rekening.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
            'no_rekening' => 'required|string|max:50|unique:rekening,no_rekening',
            'atas_nama' => 'required|string|max:100',
            'qris' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'nama_bank.required' => 'Nama bank wajib diisi.',
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'no_rekening.unique' => 'Nomor rekening ini sudah terdaftar.',
            'atas_nama.required' => 'Nama pemilik rekening wajib diisi.',
            'logo.image' => 'Logo harus berupa gambar.',
            'qris.image' => 'QRIS harus berupa gambar.',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('bank_logos', 'public');
        }

        if ($request->hasFile('qris')) {
            $data['qris'] = $request->file('qris')->store('qris_codes', 'public');
        }

        Rekening::create($data);

        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('admin.rekening.edit', compact('rekening'));
    }

    public function update(Request $request, $id)
    {
        $rekening = Rekening::findOrFail($id);

        $request->validate([
            'nama_bank' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
            'no_rekening' => 'required|string|max:50|unique:rekening,no_rekening,' . $id . ',id_rekening',
            'atas_nama' => 'required|string|max:100',
            'qris' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'nama_bank.required' => 'Nama bank wajib diisi.',
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'no_rekening.unique' => 'Nomor rekening ini sudah digunakan.',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($rekening->logo) {
                Storage::disk('public')->delete($rekening->logo);
            }
            $data['logo'] = $request->file('logo')->store('bank_logos', 'public');
        }

        if ($request->hasFile('qris')) {
            if ($rekening->qris) {
                Storage::disk('public')->delete($rekening->qris);
            }
            $data['qris'] = $request->file('qris')->store('qris_codes', 'public');
        }

        $rekening->update($data);

        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil diperbarui!');
    }

    /**
     * Hapus Rekening dengan penanganan relasi dan urutan storage yang benar.
     */
    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        
        // 1. REM DARURAT: Cek apakah rekening masih digunakan di program manapun
        // Asumsi nama relasi di model Rekening adalah 'programs'
        if ($rekening->programs()->exists()) {
            return redirect()->route('rekening.index')->withErrors([
                'error' => 'Gagal menghapus! Rekening ini masih terhubung dengan ' . $rekening->programs()->count() . ' program aktif.'
            ]);
        }

        try {
            // Simpan path file untuk dihapus nanti
            $logoPath = $rekening->logo;
            $qrisPath = $rekening->qris;

            // 2. Hapus data dari database TERLEBIH DAHULU
            $rekening->delete();

            // 3. Jika penghapusan database sukses, baru hapus file fisik di storage
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            if ($qrisPath) {
                Storage::disk('public')->delete($qrisPath);
            }

            return redirect()->route('rekening.index')->with('success', 'Rekening berhasil dihapus secara permanen.');

        } catch (\Exception $e) {
            return redirect()->route('rekening.index')->withErrors([
                'error' => 'Terjadi kesalahan sistem: Data rekening tidak dapat dihapus.'
            ]);
        }
    }
}