@extends('layouts.admin')

@section('header_title', 'Edit Program')

@section('content')
<div class="max-w-5xl bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-8 border-b pb-4 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Edit Detail Program</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi kampanye dan metode pembayaran.</p>
        </div>
        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg border border-blue-100">
            ID: #{{ $program->id_program }}
        </span>
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

    <form action="{{ route('program.update', $program->id_program) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-4">
                <label class="block text-sm font-bold text-gray-700">Banner Program</label>
                <div class="relative group">
                    <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-orange-50 hover:border-[#D35400] transition overflow-hidden">
                        <img id="banner-preview" src="{{ asset('storage/' . $program->banner) }}" alt="Preview" class="w-full h-full object-cover rounded-2xl">
                        <input type="file" name="banner" class="hidden" id="banner-input" accept="image/*" />
                        
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <span class="text-white text-xs font-bold bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl border border-white/30">
                                <i class="fa-solid fa-camera mr-2"></i> Ganti Banner
                            </span>
                        </div>
                    </label>
                </div>
                <p class="text-[11px] text-gray-400 italic text-center">Kosongkan jika tidak ingin mengganti banner.</p>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Program <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_program" value="{{ old('nama_program', $program->nama_program) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="id_kategori" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ (old('id_kategori', $program->id_kategori) == $kat->id_kategori) ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Target Dana (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="target_dana" value="{{ old('target_dana', $program->target_dana) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50 font-bold text-[#D35400]" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tenggat Waktu <span class="text-red-500">*</span></label>
                        <input type="date" name="tenggat_waktu" value="{{ old('tenggat_waktu', $program->tenggat_waktu) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Program</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50">
                            <option value="Aktif" {{ $program->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Selesai" {{ $program->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Non-Aktif" {{ $program->status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>{{ old('deskripsi', $program->deskripsi) }}</textarea>
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
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    const bannerInput = document.getElementById('banner-input');
    const bannerPreview = document.getElementById('banner-preview');

    bannerInput.onchange = evt => {
        const [file] = bannerInput.files;
        if (file) {
            bannerPreview.src = URL.createObjectURL(file);
        }
    }
</script>
@endsection