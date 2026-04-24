@extends('layouts.admin')

@section('header_title', 'Tambah Rekening')

@section('content')
<div class="max-w-4xl bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">Tambah Rekening Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Lengkapi detail rekening bank dan unggah QRIS untuk memudahkan donatur.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('rekening.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank / E-Wallet <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_bank" value="{{ old('nama_bank') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" placeholder="Contoh: BSI, BCA, DANA..." required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening <span class="text-red-500">*</span></label>
                    <input type="text" name="no_rekening" value="{{ old('no_rekening') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition font-mono tracking-wider bg-gray-50" placeholder="Contoh: 7123456789" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Atas Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="atas_nama" value="{{ old('atas_nama') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D35400] outline-none transition bg-gray-50" placeholder="Contoh: Lazismu Situbondo" required>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Bank (Opsional)</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-2 pb-2 text-center px-2">
                                    <i class="fa-solid fa-building-columns text-2xl text-gray-400 mb-1"></i>
                                    <p class="text-[10px] text-gray-500">Klik untuk upload logo</p>
                                </div>
                                <input type="file" name="logo" class="hidden" id="logo-input" accept="image/*" />
                            </label>
                        </div>
                        <div class="w-24 h-24 bg-gray-100 rounded-2xl border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img id="logo-preview" src="#" alt="Logo Preview" class="hidden max-h-full max-w-full object-contain">
                            <i id="logo-icon" class="fa-solid fa-image text-gray-300 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar QRIS (Opsional)</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-2 pb-2 text-center px-2">
                                    <i class="fa-solid fa-qrcode text-2xl text-gray-400 mb-1"></i>
                                    <p class="text-[10px] text-gray-500">Klik untuk upload QRIS</p>
                                </div>
                                <input type="file" name="qris" class="hidden" id="qris-input" accept="image/*" />
                            </label>
                        </div>
                        <div class="w-24 h-24 bg-gray-100 rounded-2xl border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img id="qris-preview" src="#" alt="QRIS Preview" class="hidden max-h-full max-w-full object-contain">
                            <i id="qris-icon" class="fa-solid fa-qrcode text-gray-300 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-10 border-t pt-6">
            <a href="{{ route('rekening.index') }}" class="w-full sm:w-auto text-center px-8 py-3 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#D35400] text-white font-bold rounded-xl hover:bg-[#A14000] transition shadow-md shadow-orange-200">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Rekening
            </button>
        </div>
    </form>
</div>

<script>
    function setupPreview(inputId, previewId, iconId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const icon = document.getElementById(iconId);

        input.onchange = evt => {
            const [file] = input.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                icon.classList.add('hidden');
            }
        }
    }

    // Jalankan fungsi preview untuk kedua input
    setupPreview('logo-input', 'logo-preview', 'logo-icon');
    setupPreview('qris-input', 'qris-preview', 'qris-icon');
</script>
@endsection