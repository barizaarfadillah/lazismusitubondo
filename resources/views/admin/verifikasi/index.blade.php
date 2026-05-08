@extends('layouts.admin')

@section('header_title', 'Verifikasi Donasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Verifikasi Donasi</h2>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-t-lg shadow-sm border-b border-gray-200 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div class="flex space-x-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('admin.verifikasi.index', ['tab' => 'pending', 'search' => $search]) }}" 
               class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap transition {{ $tab == 'pending' ? 'bg-orange-100 text-orange-700' : 'text-gray-500 hover:bg-gray-100' }}">
                <i class="fas fa-clock mr-1"></i> Menunggu Verifikasi
            </a>
            <a href="{{ route('admin.verifikasi.index', ['tab' => 'berhasil', 'search' => $search]) }}" 
               class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap transition {{ $tab == 'berhasil' ? 'bg-green-100 text-green-700' : 'text-gray-500 hover:bg-gray-100' }}">
                <i class="fas fa-check-circle mr-1"></i> Berhasil
            </a>
            <a href="{{ route('admin.verifikasi.index', ['tab' => 'gagal', 'search' => $search]) }}" 
               class="px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap transition {{ $tab == 'gagal' ? 'bg-red-100 text-red-700' : 'text-gray-500 hover:bg-gray-100' }}">
                <i class="fas fa-times-circle mr-1"></i> Dibatalkan/Gagal
            </a>
        </div>

        <form action="{{ route('admin.verifikasi.index') }}" method="GET" class="w-full md:w-1/3 relative">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari donatur atau program..." 
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
                    <th class="px-6 py-4 border-b font-semibold">Tanggal</th>
                    <th class="px-6 py-4 border-b font-semibold">Donatur</th>
                    <th class="px-6 py-4 border-b font-semibold">Program</th>
                    <th class="px-6 py-4 border-b font-semibold">Nominal</th>
                    <th class="px-6 py-4 border-b font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                @forelse($donasis as $donasi)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4">
                        {{ $donasi->created_at->format('d M Y') }}<br>
                        <span class="text-xs text-gray-400">{{ $donasi->created_at->format('H:i') }} WIB</span>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ $donasi->user->nama ?? 'Anonim' }}</td>
                    <td class="px-6 py-4">
                        <div class="truncate w-48" title="{{ $donasi->program->judul ?? '-' }}">
                            {{ $donasi->program->nama_program ?? 'Program Tidak Ditemukan' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">
                        Rp {{ number_format($donasi->nominal, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.verifikasi.show', $donasi->id_donasi) }}" 
                           class="inline-flex items-center px-3 py-1.5 {{ $tab == 'pending' ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }} rounded-md text-xs font-medium transition">
                            <i class="fas {{ $tab == 'pending' ? 'fa-search-dollar' : 'fa-eye' }} mr-1.5"></i> 
                            {{ $tab == 'pending' ? 'Proses' : 'Detail' }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300 block"></i>
                        Tidak ada data donasi dengan status <span class="font-bold uppercase">{{ $tab }}</span>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4 border-t border-gray-200">
            {{ $donasis->appends(['tab' => $tab, 'search' => $search])->links() }}
        </div>
    </div>
</div>
@endsection