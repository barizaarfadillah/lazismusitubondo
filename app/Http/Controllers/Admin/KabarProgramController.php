<?php

namespace App\Http\Controllers\Admin; // Pastikan ada sub-folder \Admin

use App\Http\Controllers\Controller;
use App\Models\KabarProgram;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KabarProgramController extends Controller
{
    public function create(Request $request)
    {
        // Mencari program berdasarkan id_program yang dikirim via URL
        $program = Program::findOrFail($request->id_program);
        
        return view('admin.kabar-program.create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_program'  => 'required|exists:program,id_program',
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'dokumentasi' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('kabar_dokumentasi', 'public');
        }

        KabarProgram::create($data);

        // Setelah simpan, kembali ke halaman detail program menggunakan slug
        $program = Program::find($request->id_program);
        return redirect()->route('program.show', $program->slug)->with('success', 'Kabar program berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kabar = KabarProgram::with('program')->findOrFail($id);
        return view('admin.kabar-program.edit', compact('kabar'));
    }

    public function update(Request $request, $id)
    {
        $kabar = KabarProgram::findOrFail($id);

        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'dokumentasi' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('dokumentasi')) {
            // Hapus file lama jika ada
            if ($kabar->dokumentasi) {
                Storage::disk('public')->delete($kabar->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('kabar_dokumentasi', 'public');
        }

        $kabar->update($data);

        return redirect()->route('program.show', $kabar->program->slug)->with('success', 'Kabar program berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kabar = KabarProgram::findOrFail($id);
        $slug = $kabar->program->slug;

        // Hapus file dari storage
        if ($kabar->dokumentasi) {
            Storage::disk('public')->delete($kabar->dokumentasi);
        }

        $kabar->delete();

        return redirect()->route('program.show', $slug)->with('success', 'Kabar program berhasil dihapus!');
    }
}