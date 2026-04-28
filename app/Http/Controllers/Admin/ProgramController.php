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
        $programs = Program::with(['kategori', 'rekenings'])
            ->withSum(['donasi as donasi_terkumpul' => function($query) {
                $query->where('status', 'Berhasil');
            }], 'nominal')
            ->latest()->get();

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
            'nama_program'  => 'required|string|max:255|unique:program,nama_program',
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'target_dana'   => 'required|numeric',
            'deskripsi'     => 'required|string',
            'tenggat_waktu' => 'required|date',
            'banner'        => 'required|image|mimes:jpg,jpeg,png|max:2048', 
            'rekening_ids'  => 'required|array',
        ], [
            'nama_program.required' => 'Nama program wajib diisi.',
            'nama_program.unique'   => 'Nama program ini sudah digunakan.',
            'id_kategori.required'  => 'Kategori program harus dipilih.',
            'target_dana.numeric'   => 'Target dana harus berupa angka.',
            'banner.required'       => 'Banner program wajib diunggah.',
            'banner.image'          => 'File harus berupa gambar (JPG, JPEG, PNG).',
            'rekening_ids.required' => 'Pilih minimal satu rekening untuk program ini.',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_program);

        // Proses Upload Banner
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('program_banners', 'public');
        }

        $program = Program::create($data);
        $program->rekenings()->attach($request->rekening_ids);

        return redirect()->route('program.index')->with('success', 'Program berhasil dipublikasikan!');
    }

    /**
     * Tampilkan detail program (beserta kabar dan jumlah donatur)
     */
    public function show(Program $program)
        {
            $program->load([
            'kategori', 
            'kabar_program' => fn($q) => $q->latest(),
            // Memuat donasi yang berhasil beserta data user terkait
            'donasi' => function($q) {
                $q->with('user')->where('status', 'Berhasil')->latest();
            }
        ]);

        $program->loadSum(['donasi as donasi_terkumpul' => function($query) {
            $query->where('status', 'Berhasil');
        }], 'nominal');

        $jumlahDonatur = $program->donasi->count();

        return view('admin.program.show', compact('program', 'jumlahDonatur'));
    }

    /**
     * Form edit program.
     */
    public function edit(Program $program)
    {
        $kategori = Kategori::all();
        $rekening = Rekening::all();
        $selectedRekenings = $program->rekenings->pluck('id_rekening')->toArray();

        return view('admin.program.edit', compact('program', 'kategori', 'rekening', 'selectedRekenings'));
    }

    /**
     * Perbarui data program.
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            // Validasi unique dengan pengecualian ID program yang sedang diedit
            'nama_program'  => 'required|string|max:255|unique:program,nama_program,' . $program->id_program . ',id_program',
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'target_dana'   => 'required|numeric',
            'deskripsi'     => 'required|string',
            'tenggat_waktu' => 'required|date',
            'banner'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'rekening_ids'  => 'required|array',
        ], [
            'nama_program.required' => 'Nama program wajib diisi.',
            'nama_program.unique'   => 'Nama program ini sudah digunakan oleh program lain.',
            'id_kategori.required'  => 'Kategori program harus dipilih.',
            'target_dana.required'  => 'Target dana wajib diisi.',
            'target_dana.numeric'   => 'Target dana harus berupa angka.',
            'tenggat_waktu.required'=> 'Tenggat waktu wajib diisi.',
            'deskripsi.required'    => 'Deskripsi program wajib diisi.',
            'banner.image'          => 'File banner harus berupa gambar (JPG, JPEG, PNG).',
            'banner.max'            => 'Ukuran banner maksimal 2MB.',
            'rekening_ids.required' => 'Pilih minimal satu rekening untuk program ini.',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_program);

        if ($request->hasFile('banner')) {
            // Hapus banner lama jika ada
            if ($program->banner) {
                Storage::disk('public')->delete($program->banner);
            }
            $data['banner'] = $request->file('banner')->store('program_banners', 'public');
        }

        $program->update($data);
        $program->rekenings()->sync($request->rekening_ids);

        return redirect()->route('program.index')->with('success', 'Perubahan program berhasil disimpan!');
    }

    /**
     * Hapus program.
     */
    public function destroy(Program $program)
    {
        // 1. Cek Relasi Donasi (Rem Darurat)
        if ($program->donasi()->exists()) {
            return redirect()->route('program.index')->withErrors([
                'error' => 'Gagal menghapus! Program "' . $program->nama_program . '" sudah memiliki transaksi donasi masuk.'
            ]);
        }

        // 2. Cek Relasi Kabar Program
        if ($program->kabar_program()->exists()) {
            return redirect()->route('program.index')->withErrors([
                'error' => 'Program tidak bisa dihapus karena memiliki data riwayat kabar/perkembangan program.'
            ]);
        }

        try {
            $bannerPath = $program->banner;

            // 3. Lepas relasi pivot rekening dan hapus data dari DB terlebih dahulu
            $program->rekenings()->detach(); 
            $program->delete();

            // 4. Baru hapus file fisik banner jika DB sukses
            if ($bannerPath) {
                Storage::disk('public')->delete($bannerPath);
            }

            return redirect()->route('program.index')->with('success', 'Program berhasil dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->route('program.index')->withErrors([
                'error' => 'Terjadi kesalahan sistem: Data tidak dapat dihapus.'
            ]);
        }
    }
}