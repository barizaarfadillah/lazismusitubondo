@extends('layouts.admin')

@section('header_title', 'Edit Rekening')

@section('content')
<div class="mb-6">
    <a href="{{ route('rekening.index') }}" class="text-sm font-bold text-gray-500 hover:text-[#D35400] transition flex items-center">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Rekening Donasi
    </a>
</div>

<div class="max-w-4xl bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">Edit Rekening</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi rekening atau ganti gambar logo dan QRIS.</p>
    </div>

    <form action="{{ route('rekening.update', $rekening->id_rekening) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank</label>
                    <input type="text" name="nama_bank" value="{{ old('nama_bank', $rekening->nama_bank) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening</label>
                    <input type="text" name="no_rekening" value="{{ old('no_rekening', $rekening->no_rekening) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition font-mono tracking-wider bg-gray-50" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Atas Nama</label>
                    <input type="text" name="atas_nama" value="{{ old('atas_nama', $rekening->atas_nama) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" required>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Logo Bank</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" name="logo" id="logo-input" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700">
                        </div>
                        <div class="w-20 h-20 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center overflow-hidden">
                            <img id="logo-preview" src="{{ $rekening->logo ? asset('storage/'.$rekening->logo) : '#' }}" class="{{ $rekening->logo ? '' : 'hidden' }} max-h-full max-w-full object-contain">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Gambar QRIS</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" name="qris" id="qris-input" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700">
                        </div>
                        <div class="w-20 h-20 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center overflow-hidden">
                            <img id="qris-preview" src="{{ $rekening->qris ? asset('storage/'.$rekening->qris) : '#' }}" class="{{ $rekening->qris ? '' : 'hidden' }} max-h-full max-w-full object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-10 border-t pt-6">
            <a href="{{ route('rekening.index') }}" class="px-8 py-3 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-8 py-3 bg-[#D35400] text-white font-bold rounded-xl hover:bg-[#A14000] shadow-md shadow-orange-200">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    function setupPreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        input.onchange = evt => {
            const [file] = input.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }
    }
    setupPreview('logo-input', 'logo-preview');
    setupPreview('qris-input', 'qris-preview');
</script>
@endsection