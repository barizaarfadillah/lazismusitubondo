@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Donatur</h2>
        <a href="{{ route('admin.donatur.create') }}" class="bg-[#D35400] text-white px-4 py-2 rounded-xl font-bold hover:bg-[#A14000] transition shadow-sm flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i> Tambah Donatur
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-t-lg shadow-sm border-b border-gray-200 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div class="flex space-x-2">
            <a href="{{ route('admin.donatur.index', ['tab' => 'aktif', 'search' => $search]) }}" 
               class="px-4 py-2 text-sm font-medium rounded-md transition {{ $tab == 'Aktif' ? 'bg-orange-100 text-orange-700' : 'text-gray-500 hover:bg-gray-100' }}">
                Donatur Aktif
            </a>
            <a href="{{ route('admin.donatur.index', ['tab' => 'nonaktif', 'search' => $search]) }}" 
               class="px-4 py-2 text-sm font-medium rounded-md transition {{ $tab == 'Nonaktif' ? 'bg-red-100 text-red-700' : 'text-gray-500 hover:bg-gray-100' }}">
                Nonaktif
            </a>
        </div>

        <form action="{{ route('admin.donatur.index') }}" method="GET" class="w-full md:w-1/3 relative">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, atau no. HP..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 text-sm">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <i class="fas fa-search"></i>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-b-lg shadow-sm overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider text-left">
                <tr>
                    <th class="px-6 py-4 border-b font-semibold">Nama Donatur</th>
                    <th class="px-6 py-4 border-b font-semibold">Kontak</th>
                    <th class="px-6 py-4 border-b font-semibold">Tgl Daftar</th>
                    <th class="px-6 py-4 border-b font-semibold">Status</th>
                    <th class="px-6 py-4 border-b font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                @forelse($donaturs as $donatur)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 font-medium">{{ $donatur->nama }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-gray-800">{{ $donatur->email }}</span>
                            <span class="text-xs text-gray-500">{{ $donatur->no_telp ?? 'Belum ada No. HP' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $donatur->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @if($donatur->status_user == 'Aktif')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">AKTIF</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">NONAKTIF</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center space-x-3 flex justify-center">
                        <a href="{{ route('admin.donatur.show', $donatur->id_user) }}" class="text-blue-500 hover:text-blue-700" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <a href="{{ route('admin.donatur.edit', $donatur->id_user) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit Data">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        @if($donatur->status_user == 'Aktif')
                            <form action="{{ route('admin.donatur.destroy', $donatur->id_user) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus/menonaktifkan donatur ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" title="Nonaktifkan/Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.donatur.aktifkan', $donatur->id_user) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="text-green-500 hover:text-green-700" title="Aktifkan Kembali">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Tidak ada data donatur {{ $tab == 'nonaktif' ? 'nonaktif' : 'aktif' }} yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4 border-t border-gray-200">
            {{ $donaturs->appends(['tab' => $tab, 'search' => $search])->links() }}
        </div>
    </div>
</div>
@endsection