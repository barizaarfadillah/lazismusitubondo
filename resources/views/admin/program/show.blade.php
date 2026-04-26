@extends('layouts.admin')

@section('header_title', 'Detail Program')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <div class="flex justify-between items-center">
        <a href="{{ route('program.index') }}" class="text-sm font-bold text-gray-500 hover:text-[#D35400] transition flex items-center">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Program
        </a>
        <a href="{{ route('program.edit', $program) }}" class="bg-blue-50 text-blue-600 px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-blue-600 hover:text-white transition shadow-sm flex items-center">
            <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Program
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
        
        <div class="lg:col-span-3">
            <div class="rounded-[1rem] overflow-hidden shadow-lg border border-gray-100 bg-gray-200 aspect-video relative">
                @if($program->banner)
                    <img src="{{ asset('storage/' . $program->banner) }}" alt="{{ $program->nama_program }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-image text-7xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[1rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-6 lg:p-10 flex flex-col">
                <div class="mb-4">
                    <span class="px-4 py-1.5 bg-orange-50 text-[#D35400] text-[10px] font-black rounded-xl uppercase tracking-widest border border-orange-100">
                        {{ $program->kategori->nama_kategori }}
                    </span>
                    <h1 class="text-2xl lg:text-2.5xl font-black text-gray-800 leading-tight mt-5">{{ $program->nama_program }}</h1>
                </div>

                <div class="space-y-3.5">
                    <div>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl lg:text-2xl font-black text-[#D35400]">Rp {{ number_format($program->dana_terkumpul, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-xs text-gray-400 font-medium italic mt-1 uppercase tracking-tighter">Dana Terkumpul</p>
                    </div>

                    @php
                        $target = $program->target_dana > 0 ? $program->target_dana : 1;
                        $persen = min(round(($program->dana_terkumpul / $target) * 100), 100);
                    @endphp
                    <div class="space-y-3">
                        <div class="w-full bg-gray-100 rounded-full h-3.5 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-[#D35400] to-[#FF7E29] h-full rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(211,84,0,0.2)]" style="width: {{ $persen }}%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[11px] font-black text-gray-500">
                            <span class="uppercase tracking-widest">Target: Rp {{ number_format($program->target_dana, 0, ',', '.') }}</span>
                            <span class="text-[#D35400] bg-orange-50 px-2 py-0.5 rounded-lg border border-orange-100">{{ $persen }}%</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-2 border-y border-gray-50 my-4">
                        <div class="text-center border-r border-gray-50">
                            <p class="text-xl font-black text-gray-800">{{ $jumlahDonatur ?? 0 }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Donatur</p>
                        </div>
                        @php
                            $tenggat = \Carbon\Carbon::parse($program->tenggat_waktu)->startOfDay();
                            $hariIni = now()->startOfDay();
                            $sisaHari = intval($hariIni->diffInDays($tenggat, false));
                        @endphp
                        <div class="text-center">
                            <p class="text-xl font-black {{ $sisaHari < 0 ? 'text-red-500' : 'text-gray-800' }}">
                                {{ $sisaHari < 0 ? 'Selesai' : ($sisaHari == 0 ? 'Hari Ini' : $sisaHari) }}
                            </p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Hari Lagi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex border-b bg-gray-50/30 overflow-x-auto no-scrollbar">
            <button onclick="switchTab('deskripsi')" id="tab-deskripsi" class="flex-1 min-w-[120px] py-5 text-xs font-black uppercase tracking-widest text-[#D35400] border-b-4 border-[#D35400] transition duration-300">
                Deskripsi
            </button>
            <button onclick="switchTab('kabar')" id="tab-kabar" class="flex-1 min-w-[120px] py-5 text-xs font-black uppercase tracking-widest text-gray-400 border-b-4 border-transparent hover:text-gray-600 transition duration-300">
                Info Terbaru
            </button>
            <button onclick="switchTab('donatur')" id="tab-donatur" class="flex-1 min-w-[120px] py-5 text-xs font-black uppercase tracking-widest text-gray-400 border-b-4 border-transparent hover:text-gray-600 transition duration-300">
                Donatur
            </button>
        </div>

        <div class="p-8 lg:p-12">
            <div id="content-deskripsi" class="block animate-fadeIn">
                <div class="max-w-4xl mx-auto prose prose-orange text-gray-700 leading-relaxed text-base">
                    {!! nl2br(e($program->deskripsi)) !!}
                </div>
            </div>

            <div id="content-kabar" class="hidden animate-fadeIn">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter italic">Laporan Perkembangan</h3>
                    <a href="{{ route('kabar-program.create', ['id_program' => $program->id_program]) }}" class="bg-gray-800 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase hover:bg-[#D35400] transition shadow-lg flex items-center">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Kabar
                    </a>
                </div>
                <div class="max-w-4xl mx-auto space-y-10">
                    @forelse($program->kabar_program as $kabar)
                        <div class="relative flex items-start group">
                            <div class="absolute left-0 h-12 w-12 flex items-center justify-center bg-white border-2 border-[#D35400] rounded-2xl z-10 shadow-sm group-hover:bg-[#D35400] group-hover:text-white transition duration-300">
                                <i class="fa-solid fa-bullhorn text-sm"></i>
                            </div>

                            <div class="ml-20 flex-1 bg-gray-50 p-6 rounded-lg border border-gray-100 hover:bg-white hover:border-orange-100 hover:shadow-md transition duration-300">
                                <div class="flex flex-col md:flex-row gap-6">
                                    
                                    @if($kabar->dokumentasi)
                                        <div class="w-full md:w-48 flex-shrink-0">
                                            <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm aspect-video md:aspect-square">
                                                <img src="{{ asset('storage/' . $kabar->dokumentasi) }}" 
                                                    class="w-full h-full object-cover hover:scale-110 transition duration-500">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex-1 flex flex-col">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="text-base font-black text-gray-800 leading-tight group-hover:text-[#D35400] transition">
                                                {{ $kabar->judul }}
                                            </h4>
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest bg-white px-2 py-1 rounded-lg border border-gray-100 flex-shrink-0 ml-4">
                                                {{ $kabar->created_at->format('d M Y') }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-gray-600 leading-relaxed mb-4 text-justify">
                                            {{ $kabar->deskripsi }}
                                        </p>

                                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center space-x-4 opacity-0 group-hover:opacity-100 transition duration-300">
                                            <a href="{{ route('kabar-program.edit', $kabar->id_kabar) }}" 
                                            class="text-[10px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-widest flex items-center">
                                                <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit
                                            </a>
                                            <form action="{{ route('kabar-program.destroy', $kabar->id_kabar) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Hapus kabar ini?')" 
                                                class="flex items-center">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="text-[10px] font-black text-red-500 hover:text-red-700 uppercase tracking-widest flex items-center">
                                                    <i class="fa-solid fa-trash mr-1.5"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-gray-50 rounded-[2.5rem] border-2 border-dashed border-gray-200">
                            <i class="fa-solid fa-clock-rotate-left text-5xl text-gray-200 mb-4"></i>
                            <p class="text-gray-400 font-medium italic">Belum ada kabar terbaru untuk program ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div id="content-donatur" class="hidden animate-fadeIn">
                <div class="max-w-4xl mx-auto space-y-6">
                    @forelse($program->donasi->take(10) as $donasi)
                        <div class="flex items-start p-4 border-b border-gray-50 last:border-0 transition hover:bg-gray-50/50 rounded-2xl">
                            <div class="h-12 w-12 bg-gray-100 rounded-full flex-shrink-0 flex items-center justify-center overflow-hidden border border-gray-100 shadow-inner">
                                <i class="fa-solid fa-user text-gray-300 text-xl"></i>
                            </div>
                            
                            <div class="ml-5 flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-sm font-black text-gray-800">
                                        {{ $donasi->is_anonim ? 'Hamba Allah' : ($donasi->nama ?? 'Donatur') }}
                                    </h4>
                                    <span class="text-sm font-black text-[#D35400]">
                                        Rp {{ number_format($donasi->nominal, 0, ',', '.') }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight mb-2">
                                    {{ $donasi->created_at->translatedFormat('d F Y') }}
                                </p>
                                @if($donasi->pesan)
                                    <div class="bg-orange-50/50 p-3 rounded-xl border border-orange-100/50">
                                        <p class="text-xs text-gray-600 italic">"{{ $donasi->pesan }}"</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-gray-50 rounded-[2.5rem] border-2 border-dashed border-gray-200">
                            <i class="fa-solid fa-heart-pulse text-5xl text-gray-200 mb-4"></i>
                            <p class="text-gray-400 font-medium italic">Belum ada donatur untuk program ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabName) {
        const contents = ['deskripsi', 'kabar', 'donatur'];
        contents.forEach(id => {
            const content = document.getElementById('content-' + id);
            const tab = document.getElementById('tab-' + id);
            
            if (id === tabName) {
                content.classList.replace('hidden', 'block');
                tab.classList.add('text-[#D35400]', 'border-[#D35400]');
                tab.classList.remove('text-gray-400', 'border-transparent');
            } else {
                content.classList.replace('block', 'hidden');
                tab.classList.remove('text-[#D35400]', 'border-[#D35400]');
                tab.classList.add('text-gray-400', 'border-transparent');
            }
        });
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endsection