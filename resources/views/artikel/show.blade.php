@extends('layouts.public')

@section('title', $artikel->judul . ' - Lazismu Situbondo')

@section('content')
<article class="bg-white min-h-screen pb-20">
    <div class="max-w-4xl mx-auto px-4 pt-12 pb-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-lazismu">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('artikel.index') }}" class="hover:text-lazismu">Artikel</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-gray-900 line-clamp-1">{{ $artikel->judul }}</span>
        </nav>

        <h1 class="text-3xl md:text-5xl font-black text-gray-900 leading-tight mb-6">
            {{ $artikel->judul }}
        </h1>

        <div class="flex flex-wrap items-center gap-6 py-6 border-y border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-lazismu font-bold">L</div>
                <div>
                    <p class="text-sm font-bold text-gray-900">Admin Lazismu</p>
                    <p class="text-xs text-gray-500">Kontributor Situbondo</p>
                </div>
            </div>
            <div class="text-sm text-gray-500">
                <p class="font-medium text-gray-900">{{ $artikel->created_at->format('d F Y') }}</p>
                <p>{{ $artikel->views }} Kali Dibaca</p>
            </div>
            <div class="ml-auto flex gap-2">
                <span class="bg-orange-50 text-lazismu px-4 py-1.5 rounded-full text-sm font-bold">
                    {{ $artikel->kategori }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 mb-12">
        <div class="rounded-3xl overflow-hidden shadow-2xl aspect-video">
            <img src="{{ asset('storage/' . $artikel->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $artikel->judul }}">
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4">
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! $artikel->konten !!}
        </div>
    </div>

    <div class="bg-gray-50 mt-20 py-20">
        <div class="max-w-7xl mx-auto px-4">
            <h3 class="text-2xl font-black mb-8">Baca Artikel Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedArtikels as $related)
                    <a href="{{ route('artikel.show', $related->slug) }}" class="group">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                            <img src="{{ asset('storage/' . $related->thumbnail) }}" class="h-40 w-full object-cover" alt="">
                            <div class="p-4">
                                <h4 class="font-bold text-gray-900 group-hover:text-lazismu line-clamp-2">{{ $related->judul }}</h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</article>
@endsection