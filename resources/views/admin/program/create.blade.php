@extends('layouts.admin')

@section('header_title', 'Tambah Program Baru')

@section('content')
<div class="max-w-5xl bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-8 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">Detail Program Donasi</h2>
        <p class="text-sm text-gray-500 mt-1">Luncurkan kampanye kebaikan baru dengan data yang lengkap.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('program.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-4">
                <label class="block text-sm font-bold text-gray-700">Banner Program <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-orange-50 hover:border-[#D35400] transition">
                        <div id="upload-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fa-solid fa-image text-4xl text-gray-300 mb-3"></i>
                            <p class="text-xs text-gray-500 font-medium">Klik untuk upload banner</p>
                        </div>
                        <img id="banner-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover rounded-2xl">
                        <input type="file" name="banner" class="hidden" id="banner-input" accept="image/*" required />
                    </label>
                    <div id="change-image-badge" class="hidden absolute bottom-3 right-3 bg-black/50 text-white text-[10px] px-2 py-1 rounded-lg backdrop-blur-sm">
                        Klik untuk ganti banner
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 italic text-center">Format: JPG, PNG (Maks. 2MB)</p>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Program <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_program" value="{{ old('nama_program') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" placeholder="Contoh: Sedekah Air Bersih untuk Desa" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="id_kategori" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>
                            <option value="">-- Pilih --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Target Dana (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="target_dana" value="{{ old('target_dana') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50 font-bold text-[#D35400]" placeholder="0" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tenggat Waktu <span class="text-red-500">*</span></label>
                        <input type="date" name="tenggat_waktu" value="{{ old('tenggat_waktu') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" placeholder="Jelaskan tujuan dan rincian program donasi ini..." required>{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3 border-b pb-2">Pilih Rekening Pembayaran <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($rekening as $rek)
                        <label for="rek_{{ $rek->id_rekening }}" class="flex items-center p-3 border border-gray-100 rounded-xl hover:bg-orange-50 transition cursor-pointer bg-white shadow-sm border-l-4 border-l-gray-300 has-[:checked]:border-l-[#D35400] has-[:checked]:bg-orange-50/50">
                            <input type="checkbox" name="rekening_ids[]" value="{{ $rek->id_rekening }}" id="rek_{{ $rek->id_rekening }}" class="w-5 h-5 text-[#D35400] border-gray-300 rounded focus:ring-[#D35400]" 
                            {{ (isset($selectedRekenings) && in_array($rek->id_rekening, old('rekening_ids', $selectedRekenings))) || (is_array(old('rekening_ids')) && in_array($rek->id_rekening, old('rekening_ids'))) ? 'checked' : '' }}>
                            
                            <div class="ml-3 flex items-center flex-1">
                                <div class="h-8 w-8 flex-shrink-0 bg-white border border-gray-100 rounded flex items-center justify-center p-1 mr-3">
                                    @if($rek->logo)
                                        <img src="{{ asset('storage/'.$rek->logo) }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <i class="fa-solid fa-building-columns text-gray-300 text-xs"></i>
                                    @endif
                                </div>

                                <div class="overflow-hidden">
                                    <span class="block text-xs font-black text-gray-800 uppercase tracking-tight">{{ $rek->nama_bank }}</span>
                                    <span class="block text-[10px] text-[#D35400] font-mono font-bold">{{ $rek->no_rekening }}</span>
                                    <span class="block text-[10px] text-gray-500 truncate italic">a/n {{ $rek->atas_nama }}</span>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('rekening_ids')
                        <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-12 border-t pt-6">
            <a href="{{ route('program.index') }}" class="w-full sm:w-auto text-center px-8 py-3 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#D35400] text-white font-bold rounded-xl hover:bg-[#A14000] transition shadow-md shadow-orange-200">
                <i class="fa-solid fa-rocket mr-2"></i> Publikasikan Program
            </button>
        </div>
    </form>
</div>

<script>
    const bannerInput = document.getElementById('banner-input');
    const bannerPreview = document.getElementById('banner-preview');
    const placeholder = document.getElementById('upload-placeholder');
    const badge = document.getElementById('change-image-badge');

    bannerInput.onchange = evt => {
        const [file] = bannerInput.files;
        if (file) {
            bannerPreview.src = URL.createObjectURL(file);
            bannerPreview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            badge.classList.remove('hidden');
        }
    }
</script>
@endsection