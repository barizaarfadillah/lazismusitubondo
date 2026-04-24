<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rekening; // Pastikan Model Rekening sudah ada

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
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:1024', // Max 1MB
            'no_rekening' => 'required|string|max:50|unique:rekening,no_rekening',
            'atas_nama' => 'required|string|max:100',
            'qris' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Max 2MB
        ]);

        $data = $request->all();

        // Proses upload Logo Bank
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('bank_logos', 'public');
        }

        // Proses upload QRIS
        if ($request->hasFile('qris')) {
            $data['qris'] = $request->file('qris')->store('qris_codes', 'public');
        }

        Rekening::create($data);

        return redirect()->route('rekening.index')->with('success', 'Rekening berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Menggunakan id_rekening sesuai primary key Anda
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

        // Update Logo Bank jika ada file baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($rekening->logo) {
                \Storage::disk('public')->delete($rekening->logo);
            }
            $data['logo'] = $request->file('logo')->store('bank_logos', 'public');
        }

        // Update QRIS jika ada file baru
        if ($request->hasFile('qris')) {
            // Hapus QRIS lama jika ada
            if ($rekening->qris) {
                \Storage::disk('public')->delete($rekening->qris);
            }
            $data['qris'] = $request->file('qris')->store('qris_codes', 'public');
        }

        $rekening->update($data);

        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        
        try {
            $rekening->delete();
            return redirect()->route('rekening.index')->with('success', 'Rekening berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('rekening.index')->withErrors(['error' => 'Gagal menghapus! Rekening ini mungkin sedang digunakan.']);
        }
    }
}