@extends('layouts.admin')

@section('header_title', 'Kelola Program Donasi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Program</h2>
        <p class="text-sm text-gray-500">Pantau perkembangan dana dan status program donasi.</p>
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
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 flex flex-col overflow-hidden group relative">
        
        <div class="relative h-48 bg-gray-200 overflow-hidden">
            @if($item->banner)
                <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama_program }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-300">
                    <i class="fa-solid fa-image text-4xl"></i>
                </div>
            @endif

            <div class="absolute top-3 left-3 z-20">
                <span class="{{ $item->status == 'Aktif' ? 'bg-green-500' : 'bg-gray-500' }} text-white text-[10px] font-black px-3 py-1 rounded-full shadow-sm uppercase tracking-wider">
                    {{ $item->status }}
                </span>
            </div>

            <div class="absolute top-3 right-3 z-20 opacity-100 lg:opacity-0 group-hover:opacity-100 transition duration-300">
                <form action="{{ route('program.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus program ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white/90 text-red-500 h-8 w-8 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white shadow backdrop-blur-sm transition">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="px-5 py-3 flex-1 flex flex-col">
            <p class="text-[10px] text-gray-400 mb-1 font-black uppercase tracking-widest">
                {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
            </p>
            
            <h3 class="text-base font-extrabold text-gray-800 leading-tight line-clamp-2 group-hover: transition h-10" title="{{ $item->nama_program }}">
                <a href="{{ route('program.show', $item) }}" class="after:content-[''] after:absolute after:inset-0 after:z-10">
                    {{ $item->nama_program }}
                </a>
            </h3>

            <div class="mb-2 z-20 relative">
                @php
                    $terkumpul = $item->dana_terkumpul ?? 0;
                    $target = $item->target_dana > 0 ? $item->target_dana : 1;
                    $persen = min(round(($terkumpul / $target) * 100), 100);
                @endphp
                <div class="flex justify-between items-end mb-1.5">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Terkumpul</span>
                        <span class="text-sm font-black text-green-600">Rp {{ number_format($terkumpul, 0, ',', '.') }}</span>
                    </div>
                    <span class="text-[11px] font-black text-gray-700 bg-gray-100 px-2 py-0.5 rounded-lg">{{ $persen }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden shadow-inner">
                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-full rounded-full transition-all duration-1000" style="width: {{ $persen }}%"></div>
                </div>
            </div>
            
            <div class="mt-auto pt-4 border-t border-gray-50 z-20 relative">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Target</p>
                        <p class="text-xs font-bold text-gray-800">Rp {{ number_format($item->target_dana, 0, ',', '.') }}</p>
                    </div>
                    
                    @php
                        $tenggat = \Carbon\Carbon::parse($item->tenggat_waktu)->startOfDay();
                        $hariIni = now()->startOfDay();
                        $sisaHari = intval($hariIni->diffInDays($tenggat, false));
                    @endphp
                    
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Sisa Waktu</p>
                        <div class="text-xs font-bold flex items-center justify-end {{ $sisaHari < 0 ? 'text-red-500' : 'text-gray-700' }}">
                            <i class="fa-regular fa-clock mr-1 text-[10px]"></i>
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
    </div>
    @empty
    <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
        <i class="fa-solid fa-box-open text-5xl text-gray-200 mb-4"></i>
        <p class="text-gray-400 font-medium">Belum ada program donasi.</p>
    </div>
    @endforelse

</div>
@endsection