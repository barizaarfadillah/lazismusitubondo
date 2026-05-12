@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.artikel.index') }}" class="text-gray-500 hover:text-orange-500 mr-4 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Artikel</h1>
    </div>

    <form action="{{ route('admin.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Judul Artikel</label>
            <input type="text" name="judul" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-lazismu" required value="{{ $artikel->judul }}">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                <select name="kategori" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-lazismu" required>
                    <option value="Berita" {{ $artikel->kategori == 'Berita' ? 'selected' : '' }}>Berita / Kabar Penyaluran</option>
                    <option value="Kisah Inspiratif" {{ $artikel->kategori == 'Kisah Inspiratif' ? 'selected' : '' }}>Kisah Inspiratif</option>
                    <option value="Edukasi Zakat" {{ $artikel->kategori == 'Edukasi Zakat' ? 'selected' : '' }}>Edukasi Zakat</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-lazismu" required>
                    <option value="Publish" {{ $artikel->status == 'Publish' ? 'selected' : '' }}>Publish (Tampilkan)</option>
                    <option value="Draft" {{ $artikel->status == 'Draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Thumbnail (Biarkan kosong jika tidak ingin mengubah)</label>
            @if($artikel->thumbnail)
                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="Current Thumbnail" class="w-32 h-20 object-cover rounded mb-2">
            @endif
            <input type="file" name="thumbnail" accept="image/*" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-lazismu">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Konten Artikel</label>
            <textarea name="konten" id="editor" rows="10" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-lazismu">{{ $artikel->konten }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#D35400] text-white font-bold rounded-xl hover:bg-[#A14000] transition shadow-md shadow-orange-200">Update Artikel</button>
        </div>
    </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection