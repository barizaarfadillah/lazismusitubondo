@extends('layouts.public')

@section('title', 'Lazismu Situbondo - Memberi Untuk Negeri')

@section('content')
<div class="w-full bg-white pt-6 pb-6">
    <div class="max-w-6xl mx-auto px-10 md:px-16 relative group">
        
        <div class="relative w-full aspect-[4/1.5] rounded-2xl overflow-hidden shadow-md border border-gray-50 bg-gray-50">
            @forelse($featuredPrograms as $index => $p)
                <a href="{{ route('donasi.show', $p->slug) }}" 
                   class="carousel-slide absolute inset-0 transition-opacity duration-1000 ease-in-out block w-full h-full {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" 
                   data-index="{{ $index }}">
                    @if(!empty($p->banner))
                        <img src="{{ asset('storage/' . $p->banner) }}" class="w-full h-full object-cover" alt="{{ $p->nama_program }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070" class="w-full h-full object-cover" alt="Default Image">
                    @endif
                </a>
            @empty
                <div class="absolute inset-0 z-10">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070" class="w-full h-full object-cover" alt="Lazismu Situbondo">
                </div>
            @endforelse
        </div>

        @if($featuredPrograms->count() > 1)
            <button onclick="prevSlide()" class="absolute left-0 md:left-2 top-1/2 -translate-y-1/2 z-30 w-8 h-8 md:w-11 md:h-11 bg-white hover:bg-gray-50 rounded-full flex items-center justify-center text-gray-600 shadow-md border border-gray-100 transition-all hover:scale-110 active:scale-95">
                <i class="fa-solid fa-chevron-left text-[10px] md:text-sm"></i>
            </button>
            
            <button onclick="nextSlide()" class="absolute right-0 md:right-2 top-1/2 -translate-y-1/2 z-30 w-8 h-8 md:w-11 md:h-11 bg-white hover:bg-gray-50 rounded-full flex items-center justify-center text-gray-600 shadow-md border border-gray-100 transition-all hover:scale-110 active:scale-95">
                <i class="fa-solid fa-chevron-right text-[10px] md:text-sm"></i>
            </button>
        @endif

        @if($featuredPrograms->count() > 1)
            <div class="flex justify-center items-center gap-2 mt-4">
                @foreach($featuredPrograms as $index => $p)
                    <button class="carousel-dot h-2.5 rounded-full transition-all duration-300 {{ $index == 0 ? 'bg-orange-500 w-8' : 'bg-gray-300 w-2.5 hover:bg-gray-400' }}" onclick="goToSlide({{ $index }})"></button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="max-w-6xl mx-auto px-4 mt-8 mb-8 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-[#FCE181] rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-white rounded-full flex items-center justify-center text-orange-500 shadow-sm shrink-0">
                    <i class="fa-solid fa-list-ul text-lg md:text-xl"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-xs md:text-sm font-medium text-gray-700 mb-0.5">Jumlah Program Donasi</p>
                    <p class="text-xl md:text-2xl font-black text-gray-900 leading-none">{{ $totalPrograms }}</p>
                </div>
            </div>

            <div class="bg-[#FCE181] rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-white rounded-full flex items-center justify-center text-orange-500 shadow-sm shrink-0">
                    <i class="fa-solid fa-hand-holding-dollar text-lg md:text-xl"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-xs md:text-sm font-medium text-gray-700 mb-0.5">Total Dana Terkumpul</p>
                    <p class="text-xl md:text-2xl font-black text-gray-900 leading-none">Rp {{ number_format($totalDana, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-[#FCE181] rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-white rounded-full flex items-center justify-center text-orange-500 shadow-sm shrink-0">
                    <i class="fa-solid fa-users text-lg md:text-xl"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-xs md:text-sm font-medium text-gray-700 mb-0.5">Jumlah Donatur</p>
                    <p class="text-xl md:text-2xl font-black text-gray-900 leading-none">{{ number_format($totalDonatur, 0, ',', '.') }}</p>
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8 border-t border-gray">
        <div class="flex justify-center text-center mb-12">
            <div class="flex flex-col items-center">
                <img class="h-10 w-auto" src="{{ asset('images/Padi-Lazismu.jpg') }}" alt="Logo Lazismu">
                <h2 class="text-3xl font-black text-gray-900">Pilihan Program Kebaikan</h2>
                <p class="text-gray-500 mt-2 text-lg">Salurkan Zakat, Infaq, dan Sedekah Anda melalui program unggulan kami hari ini.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredPrograms->take(6) as $p)
                {{-- Ubah div menjadi tag <a> dan arahkan ke detail program --}}
                <a href="{{ route('donasi.show', $p->slug) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                    
                    {{-- Banner/Thumbnail --}}
                    <div class="relative h-52 overflow-hidden bg-gray-100">
                        @if(!empty($p->banner))
                            <img src="{{ asset('storage/' . $p->banner) }}" alt="{{ $p->nama_program }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb0?q=80&w=1000" alt="Default" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        
                        <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-black text-lazismu shadow-sm uppercase tracking-wider">
                            {{ $p->kategori->nama_kategori ?? 'Umum' }}
                        </div>
                    </div>

                    {{-- Konten --}}
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-lazismu transition-colors leading-snug">
                            {{ $p->nama_program }}
                        </h3>

                        <div class="mt-auto pt-4 border-t border-gray-50">
                            @php
                                $terkumpul = $p->donasi_terkumpul ?? 0;
                                $target = $p->target_dana ?? 0;
                                $persen = $target > 0 ? min(100, round(($terkumpul / $target) * 100)) : 0;
                            @endphp

                            <div class="flex justify-between text-xs text-gray-400 mb-1 font-bold uppercase tracking-wider">
                                <span>Terkumpul</span>
                                <span>Target</span>
                            </div>
                            
                            <div class="flex justify-between items-end mb-3">
                                <span class="text-base font-black text-lazismu">Rp {{ number_format($terkumpul, 0, ',', '.') }}</span>
                                <span class="text-xs font-bold text-gray-500">Rp {{ number_format($target, 0, ',', '.') }}</span>
                            </div>

                            <div class="w-full bg-gray-100 rounded-full h-2.5 mb-6 overflow-hidden">
                                <div class="bg-lazismu h-2.5 rounded-full relative overflow-hidden" style="width: {{ $persen }}%">
                                    <div class="absolute top-0 left-0 bottom-0 right-0 bg-white/20"></div>
                                </div>
                            </div>

                            {{-- Ubah <a> di dalam tombol menjadi <div> agar tidak terjadi nested link (link di dalam link) --}}
                            <div class="block w-full text-center px-4 py-3 bg-orange-50 text-orange-600 rounded-xl font-bold group-hover:bg-lazismu group-hover:text-white transition-all shadow-sm">
                                Donasi Sekarang
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            <a href="{{ route('donasi.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 border-2 border-orange-100 rounded-2xl font-bold text-lg hover:bg-lazismu hover:text-white hover:border-lazismu transition-all shadow-sm group">
                Lihat Semua Program 
                <i class="fa-solid fa-arrow-right ml-3 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>

    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 py-8 border-t border-gray">
            <div class="flex justify-center text-center mb-12">
                <div class="flex flex-col items-center">
                    <img class="h-10 w-auto" src="{{ asset('images/Padi-Lazismu.jpg') }}" alt="Logo Lazismu">
                    <h2 class="text-3xl font-black text-gray-900">Kabar & Artikel Terbaru</h2>
                    <p class="text-gray-500 mt-2 text-lg">Ikuti perkembangan penyaluran donasi dan edukasi seputar ZIS.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($artikels as $artikel)
                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group flex flex-col">
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            @if($artikel->thumbnail)
                                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fa-regular fa-image text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-[#D35400] shadow-sm">
                                {{ $artikel->kategori }}
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                                <span class="flex items-center gap-1"><i class="fa-regular fa-calendar"></i> {{ $artikel->created_at->format('d M Y') }}</span>
                                <span class="flex items-center gap-1"><i class="fa-regular fa-eye"></i> {{ $artikel->views }}x dibaca</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#D35400] transition-colors">
                                {{ $artikel->judul }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($artikel->konten), 100) }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-50 flex items-center text-[#D35400] font-semibold text-sm">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-400 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                        <i class="fa-regular fa-newspaper text-4xl mb-3 block"></i>
                        <p>Belum ada artikel yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
            <a href="{{ route('artikel.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 border-2 border-orange-100 rounded-2xl font-bold text-lg hover:bg-lazismu hover:text-white hover:border-lazismu transition-all shadow-sm group">
                Lihat Semua Artikel
                <i class="fa-solid fa-arrow-right ml-3 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;

        if(totalSlides <= 1) return; 

        window.goToSlide = function(index) {
            // 1. Sembunyikan slide dan kecilkan dot yang sedang aktif
            slides[currentSlide].classList.remove('opacity-100', 'z-10');
            slides[currentSlide].classList.add('opacity-0', 'z-0');
            if(dots[currentSlide]) {
                dots[currentSlide].classList.remove('bg-orange-500', 'w-8');
                dots[currentSlide].classList.add('bg-gray-300', 'w-2.5'); // Kembalikan jadi bulat
            }

            // 2. Tampilkan slide baru dan panjangkan dot-nya
            currentSlide = index;
            slides[currentSlide].classList.remove('opacity-0', 'z-0');
            slides[currentSlide].classList.add('opacity-100', 'z-10');
            if(dots[currentSlide]) {
                dots[currentSlide].classList.remove('bg-gray-300', 'w-2.5');
                dots[currentSlide].classList.add('bg-orange-500', 'w-8'); // Jadikan memanjang
            }
        }

        window.nextSlide = () => goToSlide((currentSlide + 1) % totalSlides);
        window.prevSlide = () => goToSlide((currentSlide - 1 + totalSlides) % totalSlides);

        let slideInterval = setInterval(window.nextSlide, 2000);
        const container = document.querySelector('.group');
        container.addEventListener('mouseenter', () => clearInterval(slideInterval));
        container.addEventListener('mouseleave', () => slideInterval = setInterval(window.nextSlide, 2000));
    });
</script>
@endsection