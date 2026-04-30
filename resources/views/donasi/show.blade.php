@extends('layouts.public')

@section('title', $program->nama_program . ' - Lazismu Situbondo')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-4 py-8">

        <nav class="flex text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-6">
            <a href="{{ route('donasi.index') }}" class="hover:text-lazismu">Program</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800">{{ $program->kategori->nama_kategori }}</span>
        </nav>

        <div class="bg-white rounded-[1rem] overflow-hidden shadow-sm border border-gray-100 mb-8 p-6 lg:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">

                <div class="lg:col-span-7 flex flex-col justify-center">
                    <div class="w-full aspect-[6/4] rounded-xl overflow-hidden bg-gray-100 ring-1 ring-gray-100 shadow-inner">
                        <img src="{{ asset('storage/' . $program->banner) }}" alt="{{ $program->nama_program }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="lg:col-span-5 flex flex-col h-full py-2">
                    
                    <div class="mb-auto">
                        <p class="text-sm text-gray-500 mb-2 font-medium">{{ $program->kategori->nama_kategori }}</p>
                        <h1 class="text-2xl md:text-[28px] font-bold text-gray-800 leading-snug">
                            {{ $program->nama_program }}
                        </h1>
                    </div>

                    <div class="pt-8">
                        <h2 class="text-3xl font-black text-[#1a2530] tracking-tight">Rp {{ number_format($program->donasi_terkumpul ?? 0, 0, ',', '.') }}</h2>
                        <p class="text-sm text-gray-500 mb-6 font-medium">Donasi Terkumpul</p>

                        @php
                            $sisaHari = intval(now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($program->tenggat_waktu), false));
                        @endphp

                        <div class="w-full h-1 bg-gray-200 mb-4 rounded-full overflow-hidden">
                            <div class="h-full bg-[#f39c12]" style="width: 100%"></div>
                        </div>

                        <div class="flex justify-between items-center text-sm mb-6">
                            <span class="text-gray-600"><span class="font-bold text-gray-900">{{ $program->jumlah_donatur }}</span> Donatur</span>
                            <span class="text-gray-500 text-xs">{{ $sisaHari < 0 ? 'Berakhir' : $sisaHari . ' Hari lagi' }}</span>
                        </div>

                        <a href="{{ url('/program/'.$program->slug.'/donasi') }}" class="w-full bg-[#f8981d] hover:bg-[#e67e22] text-white py-4 rounded-xl font-bold text-center block transition shadow-md shadow-orange-100">
                            Tunaikan Sekarang
                        </a>

                        <div class="p-6">
                            <p class="text-xs font-bold text-lazismu mb-3 text-center uppercase tracking-widest">Bantu Sebar Kebaikan</p>
                            <div class="flex justify-center gap-4">
                                <button class="w-10 h-10 rounded-full bg-white text-green-500 flex items-center justify-center shadow-sm hover:scale-110 transition"><i class="fa-brands fa-whatsapp"></i></button>
                                <button class="w-10 h-10 rounded-full bg-white text-blue-600 flex items-center justify-center shadow-sm hover:scale-110 transition"><i class="fa-brands fa-facebook"></i></button>
                                <button class="w-10 h-10 rounded-full bg-white text-gray-800 flex items-center justify-center shadow-sm hover:scale-110 transition"><i class="fa-solid fa-link text-xs"></i></button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 p-6 lg:p-8 min-h-[400px]">
            
            <div class="border-b border-gray-100 flex space-x-8 overflow-x-auto no-scrollbar mb-8">
                <button onclick="changeTab('deskripsi', this)" class="tab-btn pb-4 text-sm font-bold text-lazismu border-b-2 border-lazismu shrink-0 focus:outline-none">
                    Deskripsi
                </button>
                <button onclick="changeTab('kabar', this)" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-600 shrink-0 focus:outline-none">
                    Info Terbaru ({{ $program->kabar_program->count() }})
                </button>
                <button onclick="changeTab('donatur', this)" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-600 shrink-0 focus:outline-none">
                    Donatur ({{ $program->jumlah_donatur }})
                </button>
            </div>

            <div id="tab-deskripsi" class="tab-content block prose prose-orange max-w-none text-gray-600 leading-relaxed">
                {!! $program->deskripsi !!}
            </div>

            <div id="tab-kabar" class="tab-content hidden">
                <div class="space-y-8 relative before:absolute before:inset-y-0 before:left-4 before:w-0.5 before:bg-gray-100">
                    @forelse($program->kabar_program as $kabar)
                        <div class="relative pl-12">
                            <div class="absolute left-2.5 top-1.5 w-3.5 h-3.5 rounded-full bg-lazismu ring-4 ring-orange-50 z-10"></div>
                            
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:shadow-md transition duration-300">
                                <div class="flex flex-col md:flex-row gap-6">
                                    
                                    @if($kabar->dokumentasi)
                                        <div class="w-full md:w-1/3 shrink-0">
                                            <div class="rounded-xl overflow-hidden shadow-sm h-40 md:h-full min-h-[160px]">
                                                <img src="{{ asset('storage/' . $kabar->dokumentasi) }}" 
                                                    class="w-full h-full object-cover transform hover:scale-110 transition duration-500" 
                                                    alt="{{ $kabar->judul }}">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex-grow">
                                        <div class="flex items-center gap-2 mb-2">
                                            <i class="fa-solid fa-calendar-day text-[10px] text-gray-400"></i>
                                            <span class="text-[10px] font-bold text-lazismu uppercase tracking-widest">
                                                {{ $kabar->created_at->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                        
                                        <h4 class="font-bold text-gray-800 text-lg mb-3 leading-tight">
                                            {{ $kabar->judul }}
                                        </h4>
                                        
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $kabar->deskripsi }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="pl-12 py-10 text-center md:text-left">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto md:mx-0 mb-4">
                                <i class="fa-solid fa-clipboard-list text-gray-300 text-xl"></i>
                            </div>
                            <p class="text-gray-400 text-sm italic">Belum ada pembaruan atau dokumentasi untuk program ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div id="tab-donatur" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($donaturList as $dn)
                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-100 hover:bg-gray-50 transition">
                            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-lazismu font-bold shadow-inner">
                                {{ substr($dn->is_anonim ? 'H' : ($dn->user->nama ?? 'D'), 0, 1) }}
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <h5 class="text-sm font-bold text-gray-800">{{ $dn->is_anonim ? 'Hamba Allah' : ($dn->user->nama ?? 'Donatur') }}</h5>
                                    <span class="text-xs font-black text-lazismu">Rp {{ number_format($dn->nominal, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-[10px] text-gray-400 font-medium">{{ $dn->created_at->diffForHumans() }}</p>
                                @if($dn->pesan_doa)
                                    <p class="text-xs text-gray-500 italic mt-1 font-serif line-clamp-2">"{{ $dn->pesan_doa }}"</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm italic text-center w-full py-8">Jadilah donatur pertama untuk program ini.</p>
                    @endforelse
                </div>
            </div>

        </div>
        </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    function changeTab(tabName, clickedBtn) {
        // 1. Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        // 2. Tampilkan konten tab yang dipilih
        document.getElementById('tab-' + tabName).classList.remove('hidden');
        document.getElementById('tab-' + tabName).classList.add('block');

        // 3. Reset warna semua tombol tab ke abu-abu
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-lazismu', 'border-lazismu');
            btn.classList.add('text-gray-400', 'border-transparent');
        });

        // 4. Beri warna oranye (aktif) pada tombol yang diklik
        clickedBtn.classList.remove('text-gray-400', 'border-transparent');
        clickedBtn.classList.add('text-lazismu', 'border-lazismu');
    }
</script>
@endsection