<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Kategori;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    /**
     * Tampilkan daftar semua program.
     */
    public function index()
    {
        // Eager loading relasi kategori dan rekenings agar query efisien
        $programs = Program::with(['kategori', 'rekenings'])->latest()->get();
        return view('admin.program.index', compact('programs'));
    }

    /**
     * Form tambah program baru.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $rekening = Rekening::all();
        return view('admin.program.create', compact('kategori', 'rekening'));
    }

    /**
     * Simpan program baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_program'  => 'required|string|max:255',
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'target_dana'   => 'required|numeric',
            'deskripsi'     => 'required|string',
            'tenggat_waktu' => 'required|date',
            'banner'        => 'required|image|mimes:jpg,jpeg,png|max:2048', // Ubah ke banner
            'rekening_ids'  => 'required|array',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_program);

        // Proses Upload Banner
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('program_banners', 'public');
        }

        $program = Program::create($data);
        $program->rekenings()->attach($request->rekening_ids);

        return redirect()->route('program.index')->with('success', 'Program berhasil dibuat!');
    }

    /**
     * Form edit program.
     */
    public function edit($id)
    {
        $program = Program::with('rekenings')->findOrFail($id);
        $kategori = Kategori::all();
        $rekening = Rekening::all();

        // Mengambil ID rekening yang sudah terpilih untuk dicentang di view
        $selectedRekenings = $program->rekenings->pluck('id_rekening')->toArray();

        return view('admin.program.edit', compact('program', 'kategori', 'rekening', 'selectedRekenings'));
    }

    /**
     * Perbarui data program.
     */
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $request->validate([
            'nama_program'  => 'required|string|max:255',
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'target_dana'   => 'required|numeric',
            'deskripsi'     => 'required|string',
            'tenggat_waktu' => 'required|date',
            'banner'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Ubah ke banner
            'rekening_ids'  => 'required|array',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_program);

        if ($request->hasFile('banner')) {
            if ($program->banner) {
                Storage::disk('public')->delete($program->banner);
            }
            $data['banner'] = $request->file('banner')->store('program_banners', 'public');
        }

        $program->update($data);
        $program->rekenings()->sync($request->rekening_ids);

        return redirect()->route('program.index')->with('success', 'Program berhasil diperbarui!');
    }

    /**
     * Hapus program.
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        // Hapus file gambar dari storage
        if ($program->gambar) {
            Storage::disk('public')->delete($program->gambar);
        }

        // Relasi di tabel pivot akan otomatis terhapus karena onDelete('cascade') di migrasi
        $program->delete();

        return redirect()->route('program.index')->with('success', 'Program telah dihapus.');
    }
}