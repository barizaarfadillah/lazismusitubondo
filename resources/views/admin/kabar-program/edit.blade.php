@extends('layouts.admin')

@section('header_title', 'Edit Kabar Program')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('program.show', $kabar->program->slug) }}" class="text-sm font-bold text-gray-500 hover:text-[#D35400] transition flex items-center">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Detail
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="p-8 border-b bg-gray-50/50">
            <h2 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Edit Kabar Terbaru</h2>
            <p class="text-xs text-gray-500 mt-1 italic">Program: {{ $kabar->program->nama_program }}</p>
        </div>

        <form action="{{ route('kabar-program.update', $kabar->id_kabar) }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Judul Kabar</label>
                        <input type="text" name="judul" value="{{ old('judul', $kabar->judul) }}" 
                               class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#D35400] outline-none transition font-bold text-gray-700" required>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Isi Kabar / Update</label>
                        <textarea name="deskripsi" rows="8" 
                                  class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#D35400] outline-none transition text-gray-600 text-sm leading-relaxed" required>{{ old('deskripsi', $kabar->deskripsi) }}</textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Dokumentasi</label>
                    
                    <div class="relative group">
                        <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-100 border-dashed rounded-[2rem] cursor-pointer bg-gray-50 hover:bg-orange-50 hover:border-orange-200 transition overflow-hidden">
                            <img id="preview-img" src="{{ $kabar->dokumentasi ? asset('storage/'.$kabar->dokumentasi) : '#' }}" 
                                 class="{{ $kabar->dokumentasi ? '' : 'hidden' }} w-full h-full object-cover">
                            
                            <div id="placeholder-box" class="{{ $kabar->dokumentasi ? 'hidden' : '' }} flex flex-col items-center">
                                <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-200 mb-3"></i>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Klik untuk ganti foto</p>
                            </div>

                            <input type="file" name="dokumentasi" id="file-input" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <p class="text-[10px] text-gray-400 italic text-center">Kosongkan jika tidak ingin mengubah foto dokumentasi.</p>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-gray-50">
                <button type="submit" class="px-10 py-4 bg-[#D35400] text-white font-black rounded-2xl shadow-lg shadow-orange-100 hover:bg-[#A14000] transition transform hover:-translate-y-1 uppercase text-xs tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('file-input');
    const previewImg = document.getElementById('preview-img');
    const placeholderBox = document.getElementById('placeholder-box');

    fileInput.onchange = evt => {
        const [file] = fileInput.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewImg.classList.remove('hidden');
            placeholderBox.classList.add('hidden');
        }
    }
</script>
@endsection