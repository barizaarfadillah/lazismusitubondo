<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan Facade ini di-import

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
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('bank_logos', 'public');
        }

        if ($request->hasFile('qris')) {
            $data['qris'] = $request->file('qris')->store('qris_codes', 'public');
        }

        Rekening::create($data);

        return redirect()->route('rekening.index')->with('success', 'Rekening berhasil ditambahkan!');
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
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($rekening->logo) {
                Storage::disk('public')->delete($rekening->logo);
            }
            $data['logo'] = $request->file('logo')->store('bank_logos', 'public');
        }

        if ($request->hasFile('qris')) {
            // Hapus QRIS lama jika ada
            if ($rekening->qris) {
                Storage::disk('public')->delete($rekening->qris);
            }
            $data['qris'] = $request->file('qris')->store('qris_codes', 'public');
        }

        $rekening->update($data);

        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil diperbarui!');
    }

    /**
     * Hapus Rekening beserta file gambarnya.
     */
    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        
        try {
            // 1. Hapus file logo dari storage jika ada
            if ($rekening->logo) {
                Storage::disk('public')->delete($rekening->logo);
            }

            // 2. Hapus file QRIS dari storage jika ada
            if ($rekening->qris) {
                Storage::disk('public')->delete($rekening->qris);
            }

            // 3. Hapus data dari database
            $rekening->delete();

            return redirect()->route('rekening.index')->with('success', 'Rekening dan file terkait berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('rekening.index')->withErrors(['error' => 'Gagal menghapus! Rekening ini mungkin masih terhubung dengan program donasi aktif.']);
        }
    }
}