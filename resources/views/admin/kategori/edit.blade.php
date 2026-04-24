@extends('layouts.admin')

@section('header_title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">Edit Kategori</h2>
        <p class="text-sm text-gray-500 mt-1">Ubah nama kategori program donasi.</p>
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

    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
        @csrf
        @method('PUT') <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#D35400] transition bg-gray-50" required>
        </div>
        
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8">
            <a href="{{ route('kategori.index') }}" class="w-full sm:w-auto text-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-[#D35400] text-white font-bold rounded-xl hover:bg-[#A14000] transition shadow-md">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Update Kategori
            </button>
        </div>
    </form>
</div>
@endsection