@extends('layouts.public')

@section('title', 'Program Donasi - Lazismu Situbondo')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    
    <div class="bg-white border-b border-gray-100 py-12 mb-8">
        @if(session('success'))
            <div class="max-w-7xl mx-auto text-center p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 shadow-sm mb-6">
                <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="text-sm text-green-800 font-medium">
                    {{ session('success') }}
                </p>
            </div>
        @endif
        
        <div class="max-w-7xl mx-auto px-4 pt-4 text-center">
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">Pilih Program Kebaikanmu</h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Salurkan bantuan Anda untuk saudara kita yang membutuhkan melalui program-program pilihan Lazismu Situbondo.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        
        <div class="flex items-center gap-3 overflow-x-auto pb-6 no-scrollbar">
            <a href="{{ route('donasi.index') }}" 
               class="px-6 py-2.5 rounded-full font-bold text-sm transition shrink-0 {{ request('kategori') == '' ? 'bg-lazismu text-white shadow-md shadow-orange-200' : 'bg-white text-gray-500 border border-gray-200 hover:border-lazismu hover:text-lazismu' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('donasi.index', ['kategori' => $cat->id_kategori]) }}" 
                   class="px-6 py-2.5 rounded-full font-bold text-sm transition shrink-0 {{ request('kategori') == $cat->id_kategori ? 'bg-lazismu text-white shadow-md shadow-orange-200' : 'bg-white text-gray-500 border border-gray-200 hover:border-lazismu hover:text-lazismu' }}">
                    {{ $cat->nama_kategori }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($programs as $item)
                <div class="bg-white rounded-[1rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-500 group cursor-pointer" onclick="window.location.href='/program/{{ $item->slug }}'">
                    
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $item->banner) }}" 
                             alt="{{ $item->nama_program }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-sm text-lazismu px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                                {{ $item->kategori->nama_kategori }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="space-y-1">
                            <h3 class="font-bold text-gray-800 leading-snug group-hover:text-lazismu transition line-clamp-2">
                                {{ $item->nama_program }}
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                {{ strip_tags($item->deskripsi) }}
                            </p>
                        </div>

                        <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-lazismu rounded-full transition-all duration-1000" style="width: 100%"></div>
                        </div>
                        
                        <div class="flex justify-between items-start pt-1">
                            <div class="space-y-1">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Donasi Terkumpul</p>
                                <p class="text-sm font-black text-gray-800">
                                    Rp {{ number_format($item->donasi_terkumpul ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Jumlah Donatur</p>
                                <p class="text-sm font-black text-gray-600">
                                    {{ $item->jumlah_donatur ?? 0 }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-1">
                            <a href="{{ url('/program/' . $item->slug) }}" 
                            class="w-full bg-lazismu text-white py-3 rounded-xl font-bold text-sm hover:bg-lazismu_hover transition shadow-md shadow-orange-100 flex items-center justify-center gap-2 group-hover:shadow-lg">
                                Ikut Donasi
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-magnifying-glass text-2xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Program Tidak Tersedia</h3>
                    <p class="text-gray-400 text-sm">Coba pilih kategori lain atau kembali beberapa saat lagi.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@if(session('donasi_berhasil'))
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal()"></div>
        
        <div class="bg-white rounded-3xl max-w-md w-full p-6 text-center shadow-2xl z-10 relative border border-gray-100 animate-fade-in">
            <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-5">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            
            <h3 class="text-lg font-black text-gray-900 mb-2">Alhamdulillah, Terima Kasih!</h3>
            
            <p class="text-xs text-gray-500 leading-relaxed mb-6">
                Donasi Anda sedang diproses. Kuitansi akan tersedia di riwayat donasi setelah diverifikasi admin.
            </p>
            
            <div class="flex flex-col gap-3">
                <a href="{{ route('donasi.index') }}" class="w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                    Kembali ke Katalog
                </a>
                
                <a href="{{ url('/donatur/dashboard') }}" class="w-full bg-lazismu text-white py-3 rounded-xl font-bold text-sm hover:bg-lazismu_hover transition shadow-sm">
                    Lihat Riwayat Donasi
                </a>
            </div>
        </div>
    </div>
    
    <script>
        function closeModal() {
            document.getElementById('successModal').remove();
        }
    </script>
@endif

<style>
    /* Menghilangkan scrollbar pada filter kategori tapi tetap bisa di-scroll */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection