@extends('layouts.admin') @section('title', 'Kelola Artikel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Artikel & Berita</h1>
        <a href="{{ route('admin.artikel.create') }}" class="bg-[#D35400] text-white px-4 py-2 rounded-xl font-bold hover:bg-[#A14000] transition shadow-sm flex items-center justify-center w-full sm:w-auto">
            + Tambah Artikel
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-600">
                    <th class="p-4 font-semibold">Thumbnail</th>
                    <th class="p-4 font-semibold">Judul</th>
                    <th class="p-4 font-semibold text-center">Kategori</th>
                    <th class="p-4 font-semibold text-center">Status</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artikels as $artikel)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="p-4">
                            @if($artikel->thumbnail)
                                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="Thumbnail" class="w-20 h-14 object-cover rounded-md">
                            @else
                                <span class="text-gray-400 text-sm">No Image</span>
                            @endif
                        </td>
                        <td class="p-4 font-medium text-gray-800">{{ $artikel->judul }}</td>
                        <td class="p-4 text-center"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">{{ $artikel->kategori }}</span></td>
                        <td class="p-4 text-center">
                            @if($artikel->status == 'Publish')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Publish</span>
                            @else
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs font-bold">Draft</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center">
                            <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}" class="bg-blue-50 text-blue-500 h-9 w-9 rounded-lg hover:bg-blue-500 hover:text-white transition flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-500 h-9 w-9 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">Belum ada artikel yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection