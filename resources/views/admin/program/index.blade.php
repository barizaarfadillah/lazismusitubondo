@extends('layouts.admin')

@section('header_title', 'Kelola Program Donasi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Program</h2>
        <p class="text-sm text-gray-500">Kelola dan pantau semua program donasi yang sedang berjalan.</p>
    </div>
    <a href="{{ route('program.create') }}" class="bg-[#D35400] text-white px-5 py-2.5 rounded-xl font-bold hover:bg-[#A14000] transition shadow-md shadow-orange-200 flex items-center">
        <i class="fa-solid fa-plus mr-2"></i> Tambah Program
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
        <div class="flex items-center">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    
    @forelse($programs as $item)
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 flex flex-col overflow-hidden group">
        
        <div class="relative h-48 bg-gray-200 overflow-hidden">
            @if($item->banner)
                <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama_program }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-300">
                    <i class="fa-solid fa-image text-4xl"></i>
                </div>
            @endif

            <div class="absolute top-3 left-3">
                @if($item->status == 'Aktif')
                    <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Aktif</span>
                @else
                    <span class="bg-gray-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">{{ $item->status }}</span>
                @endif
            </div>

            <div class="absolute top-3 right-3 flex space-x-2 opacity-100 lg:opacity-0 group-hover:opacity-100 transition duration-300">
                <a href="{{ route('program.edit', $item->id_program) }}" class="bg-white/90 text-blue-600 h-8 w-8 rounded-lg flex items-center justify-center hover:bg-blue-600 hover:text-white shadow backdrop-blur-sm transition">
                    <i class="fa-solid fa-pen text-sm"></i>
                </a>
                <form action="{{ route('program.destroy', $item->id_program) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus program ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white/90 text-red-500 h-8 w-8 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white shadow backdrop-blur-sm transition">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="p-5 flex-1 flex flex-col">
            <div class="flex justify-between items-start mb-1">
                <p class="text-sm text-gray-500 mb-1 font-medium">{{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
            </div>
            
            <h3 class="text-lg font-extrabold text-gray-800 mb-2 leading-tight line-clamp-2" title="{{ $item->nama_program }}">
                {{ $item->nama_program }}
            </h3>

            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                {{ Str::limit(strip_tags($item->deskripsi), 80) }}
            </p>
            
            <div class="mt-auto pt-4 border-t border-orange-100/50">
                
                <div class="flex justify-between items-center mb-1">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Target Dana</p>
                        <p class="text-sm font-bold text-gray-800">Rp {{ number_format($item->target_dana, 0, ',', '.') }}</p>
                    </div>
                    
                    @php
                        $tenggat = \Carbon\Carbon::parse($item->tenggat_waktu)->startOfDay();
                        $hariIni = now()->startOfDay();
                        $sisaHari = intval($hariIni->diffInDays($tenggat, false));
                    @endphp
                    
                    <div class="text-right">
                        <p class="text-xs text-gray-500 mb-0.5">Sisa Waktu</p>
                        <div class="text-sm font-bold flex items-center justify-end {{ $sisaHari < 0 ? 'text-red-500' : 'text-gray-800' }}">
                            <i class="fa-regular fa-clock mr-1"></i>
                            @if($sisaHari < 0)
                                Berakhir
                            @elseif($sisaHari == 0)
                                Hari Ini
                            @else
                                {{ $sisaHari }} Hari
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
        <i class="fa-solid fa-box-open text-5xl text-gray-200 mb-4"></i>
        <p class="text-gray-400 font-medium">Belum ada program donasi.</p>
    </div>
    @endforelse

</div>
@endsection