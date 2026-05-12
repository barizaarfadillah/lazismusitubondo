@extends('layouts.public')

@section('title', 'Artikel & Berita - Lazismu Situbondo')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <div class="py-16 lg:py-20">
        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center flex flex-col items-center gap-5">
            <img class="h-16 w-auto drop-shadow-md" src="{{ asset('images/Padi-Lazismu.png') }}" alt="Logo Lazismu">
            <h1 class="text-4xl font-black mb-4">Artikel & Kabar Terbaru</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 -mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($artikels as $artikel)
                <a href="{{ route('artikel.show', $artikel->slug) }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                    
                    <div class="relative h-56 overflow-hidden">
                        @if($artikel->thumbnail)
                            <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <i class="fa-solid fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-lazismu shadow-sm">
                            {{ $artikel->kategori }}
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $artikel->created_at->format('d M Y') }}</span>
                            <span><i class="fa-regular fa-eye mr-1"></i> {{ $artikel->views }}x</span>
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-lazismu transition-colors">
                            {{ $artikel->judul }}
                        </h2>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-6">
                            {{ Str::limit(strip_tags($artikel->konten), 130) }}
                        </p>
                        
                        <div class="mt-auto">
                            <div class="inline-flex items-center text-lazismu font-bold group-hover:gap-3 transition-all text-sm">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 py-20 text-center">
                    <p class="text-gray-500">Belum ada artikel untuk ditampilkan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $artikels->links() }}
        </div>
    </div>
</div>
@endsection