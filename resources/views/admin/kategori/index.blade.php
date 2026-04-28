@extends('layouts.admin')

@section('header_title', 'Kelola Kategori')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Daftar Kategori Program</h3>
            <p class="text-sm text-gray-500">Kelola kategori untuk memisahkan jenis program donasi.</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="bg-[#D35400] text-white px-4 py-2 rounded-xl font-bold hover:bg-[#A14000] transition shadow-sm flex items-center justify-center w-full sm:w-auto">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <i class="fa-solid fa-circle-check text-green-500 mt-0.5"></i>
                <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <div class="flex">
                        <i class="fa-solid fa-times-circle text-red-500 mt-0.5"></i>
                        <p class="ml-3 text-sm text-red-700 font-medium">{{ $error }}</p>
                    </div>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[500px]">
            <thead>
                <tr class="text-gray-400 text-sm uppercase tracking-wider border-b">
                    <th class="p-4 font-semibold text-center w-20">No</th>
                    <th class="p-4 font-semibold text-left">Nama Kategori</th>
                    <th class="p-4 font-semibold text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kategori as $item)
                <tr class="hover:bg-orange-50 transition">
                    <td class="p-4 text-center font-medium text-gray-600">{{ $loop->iteration }}</td>
                    <td class="p-4 text-gray-800 font-semibold">{{ $item->nama_kategori }}</td>
                    <td class="p-4">
                        <div class="flex justify-center">
                            <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="bg-blue-50 text-blue-500 h-9 w-9 rounded-lg hover:bg-blue-500 hover:text-white transition flex items-center justify-center" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $item->nama_kategori }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-500 h-9 w-9 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-10 text-center text-gray-400 italic">
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-200"></i>
                            <p>Belum ada data kategori yang tersedia.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection