@extends('layouts.donatur')

@section('konten_donatur')
<div class="mb-6">
    <h4 class="text-2xl font-bold text-gray-800">Ringkasan Akun</h4>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
    
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4 flex items-center gap-4 hover:shadow-md transition duration-300">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
            <i class="fa-solid fa-wallet text-xl"></i>
        </div>
        <div class="flex flex-col overflow-hidden">
            <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Total Donasi</span>
            <h4 class="text-base font-bold text-gray-800 truncate">Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</h4>
            <p class="text-gray-400 text-[10px]">Donasi Saya</p>
        </div>
    </div>
    
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4 flex items-center gap-4 hover:shadow-md transition duration-300">
        <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
            <i class="fa fa-archive text-xl"></i>
        </div>
        <div class="flex flex-col overflow-hidden">
            <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Total Program</span>
            <h4 class="text-base font-bold text-gray-800">{{ $totalProgram ?? 0 }}</h4>
            <p class="text-gray-400 text-[10px]">Program Donasi</p>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4 flex items-center gap-4 hover:shadow-md transition duration-300">
        <div class="w-12 h-12 bg-pink-50 text-pink-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
            <i class="fa-solid fa-heart text-xl"></i>
        </div>
        <div class="flex flex-col overflow-hidden">
            <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Favorit</span>
            @if($kategoriFavorit)
                <h4 class="text-base font-bold text-gray-800 truncate" title="{{ $kategoriFavorit->nama_kategori }}">
                    {{ $kategoriFavorit->nama_kategori }}
                </h4>
                <p class="text-gray-400 text-[10px]"><span class="font-bold text-yellow-500">{{ $kategoriFavorit->total_bantu }}x</span> Berdonasi</p>
            @else
                <h4 class="text-base font-bold text-gray-800">Belum Ada</h4>
                <p class="text-gray-400 text-[10px]">Mulai berdonasi</p>
            @endif
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4 flex items-center gap-4 hover:shadow-md transition duration-300">
        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
        </div>
        <div class="flex flex-col overflow-hidden">
            <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Terakhir</span>
            @if($donasiTerakhir)
                <h4 class="text-base font-bold text-gray-800">Rp {{ number_format($donasiTerakhir->nominal ?? 0, 0, ',', '.') }}</h4>
                <p class="text-gray-400 text-[10px] truncate" title="{{ $donasiTerakhir->program->judul_program }}">
                    {{ \Carbon\Carbon::parse($donasiTerakhir->created_at)->diffForHumans() }}
                </p>
            @else
                <h4 class="text-base font-bold text-gray-800">-</h4>
                <p class="text-gray-400 text-[10px]">Belum ada riwayat</p>
            @endif
        </div>
    </div>

</div>

<div class="flex flex-col lg:flex-row gap-2 mt-4 items-stretch">
    
    <div class="lg:w-2/3">
        <div class="bg-white border border-gray-100 rounded-3xl p-6 h-full flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h4 class="text-lg font-bold text-gray-800">Statistik 6 Bulan Terakhir</h4>
                    <p class="text-gray-400 text-xs">Pantau grafik pertumbuhan kebaikan Anda.</p>
                </div>
            </div>
            
            <div class="flex-1 relative w-full min-h-[300px] flex items-center justify-center">
                @if(array_sum($chartData) > 0)
                    {{-- Tampilkan Canvas jika ada data donasi --}}
                    <canvas id="grafikDonasi"></canvas>
                @else
                    {{-- Tampilkan Info Kosong jika tidak ada data --}}
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-chart-simple text-2xl text-gray-300"></i>
                        </div>
                        <h6 class="font-bold text-gray-600 text-sm">Belum Ada Riwayat</h6>
                        <p class="text-gray-400 text-xs mt-1">Anda belum melakukan donasi dalam 6 bulan terakhir.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:w-1/3">
        <div class="bg-white border border-gray-100 rounded-xl p-6 h-full flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-xl font-bold text-gray-800">Artikel Terbaru</h4>
                <a href="{{ route('artikel.index') }}" class="text-sm font-semibold text-[#D35400] hover:underline">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse($artikels as $item)
                    <a href="{{ route('artikel.show', $item->slug) }}" class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex gap-4">
                        <div class="w-24 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-newspaper text-xl"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col justify-center overflow-hidden">
                            <h5 class="text-xs font-bold text-gray-800 line-clamp-2 leading-tight group-hover:text-[#D35400] transition-colors">
                                {{ $item->judul }}
                            </h5>
                            <p class="text-[11px] text-gray-400 mt-1">
                                <i class="fa-regular fa-calendar mr-1"></i> {{ $item->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="py-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200 text-gray-400">
                        <p class="text-sm">Belum ada artikel terbaru untuk ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f7f7f7;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cek dulu apakah elemen canvas ada di halaman
        const canvasElement = document.getElementById('grafikDonasi');
        
        if (canvasElement) {
            const ctx = canvasElement.getContext('2d');
            
            const labels = {!! json_encode($chartLabels) !!};
            const data = {!! json_encode($chartData) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Donasi (Rp)',
                        data: data,
                        backgroundColor: '#fbbf24',
                        borderRadius: 8,
                        barThickness: 24,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw || 0;
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [5, 5],
                                color: '#f1f5f9'
                            },
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000) + ' Jt';
                                    if (value >= 1000) return (value / 1000) + ' Rb';
                                    return value;
                                },
                                color: '#94a3b8',
                                font: { size: 10 }
                            },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11, weight: '500' }
                            },
                            border: { display: false }
                        }
                    }
                }
            });
        }
    });
</script>

@endsection