@extends('layouts.admin')

@section('header_title', 'Tambah Kabar Program')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('program.show', $program) }}" class="text-sm font-bold text-gray-500 hover:text-[#D35400] transition flex items-center">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Detail Program
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-800">Buat Kabar Terbaru</h2>
            <p class="text-xs text-gray-500 mt-1">Berikan informasi perkembangan untuk program: <span class="text-[#D35400] font-bold">{{ $program->nama_program }}</span></p>
        </div>

        <form action="{{ route('kabar-program.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf
            <input type="hidden" name="id_program" value="{{ $program->id_program }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Kabar <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" 
                               placeholder="Contoh: Penyaluran Sembako Tahap 1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Isi Kabar / Update <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" rows="6" 
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" 
                                  placeholder="Ceritakan detail perkembangan program di sini..." required>{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

                <div class="space-y-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Dokumentasi (Opsional)</label>
                    <div class="relative group">
                        <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-orange-50 hover:border-[#D35400] transition overflow-hidden">
                            <div id="upload-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-camera text-4xl text-gray-300 mb-3"></i>
                                <p class="text-xs text-gray-500 font-medium text-center px-4">Klik untuk unggah bukti kegiatan atau dokumentasi</p>
                            </div>
                            <img id="doc-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                            
                            <input type="file" name="dokumentasi" class="hidden" id="doc-input" accept="image/*" />
                        </label>
                    </div>
                    <p class="text-[11px] text-gray-400 italic">Format: JPG, PNG (Maks. 2MB). Dokumentasi yang baik meningkatkan kepercayaan donatur.</p>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t">
                <a href="{{ route('program.show', $program) }}" class="w-full sm:w-auto text-center px-8 py-3 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#D35400] text-white font-bold rounded-xl hover:bg-[#A14000] transition shadow-md shadow-orange-200">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Posting Kabar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const docInput = document.getElementById('doc-input');
    const docPreview = document.getElementById('doc-preview');
    const placeholder = document.getElementById('upload-placeholder');

    docInput.onchange = evt => {
        const [file] = docInput.files;
        if (file) {
            docPreview.src = URL.createObjectURL(file);
            docPreview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
    }
</script>
@endsection