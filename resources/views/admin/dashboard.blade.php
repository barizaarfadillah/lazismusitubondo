@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <p class="text-sm text-gray-500">Selamat datang, {{ Auth::user()->nama }}. Berikut adalah ringkasan sistem Lazismu saat ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 mb-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 flex items-center">
            <div class="text-orange-600 mr-4">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingDonasi }} <span class="text-sm font-normal text-gray-400">Transaksi</span></p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 flex items-center">
            <div class="text-green-600  mr-4">
                <i class="fas fa-wallet text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Dana Masuk (Bulan Ini)</p>
                <p class="text-xl font-bold text-gray-800">Rp {{ number_format($danaBulanIni, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 flex items-center">
            <div class="text-blue-600  mr-4">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Donatur</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalDonatur }} <span class="text-sm font-normal text-gray-400">Orang</span></p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 flex items-center">
            <div class="text-purple-600 mr-4">
                <i class="fas fa-box-open text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Program Donasi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $programAktif }} <span class="text-sm font-normal text-gray-400">Program</span></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Donasi</h3>
            <div class="relative h-72 w-full">
                <canvas id="donasiChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Perlu Diproses</h3>
                <a href="{{ route('admin.verifikasi.index') }}" class="text-sm text-orange-500 hover:underline">Lihat Semua</a>
            </div>
            
            <div class="space-y-4">
                @forelse($latestPending as $pending)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ $pending->user->nama ?? 'Anonim' }}</p>
                        <p class="text-xs text-gray-500">Rp {{ number_format($pending->nominal, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-400 mt-1">{{ $pending->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('admin.verifikasi.show', $pending->id_donasi) }}" class="px-3 py-1.5 bg-orange-500 text-white text-xs font-medium rounded hover:bg-orange-600 transition shrink-0">
                        Proses
                    </a>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="inline-block p-3 rounded-full bg-green-100 text-green-500 mb-3">
                        <i class="fas fa-check-double text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-500">Hebat! Tidak ada donasi yang menunggu verifikasi.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Top 5 Program Terpopuler</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @forelse($topPrograms as $index => $tp)
                <a href="{{ route('program.show', $tp->slug) }}" class="group block relative rounded-xl overflow-hidden h-48 shadow-sm hover:shadow-md transition-all duration-300">
                    
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110" 
                        style="background-image: url('{{ $tp->banner ? asset('storage/' . $tp->banner) : asset('assets/img/default-program.jpg') }}');">
                    </div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    
                    <div class="absolute inset-0 p-4 flex flex-col justify-end">
                        <div class="flex justify-between items-start mb-1">
                            <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                {{ $tp->kategori->nama_kategori ?? 'Program' }}
                            </span>
                            <span class="text-white/70 text-xs font-bold">#{{ $index + 1 }}</span>
                        </div>
                        <h4 class="text-white font-bold text-sm line-clamp-2 leading-tight mb-2">
                            {{ $tp->nama_program }}
                        </h4>
                        <div class="flex items-center justify-between mt-1 border-t border-white/20 pt-2">
                            <p class="text-[10px] text-white/70 uppercase">Dana Terkumpul</p>
                            <p class="text-xs font-black text-white">Rp {{ number_format($tp->donasi_sum_nominal ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="bg-white/20 backdrop-blur-md p-2 rounded-full text-white">
                            <i class="fas fa-external-link-alt text-[10px]"></i>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-5 text-center py-8 text-gray-500 italic border-2 border-dashed border-gray-100 rounded-xl">
                    Belum ada data program yang menerima donasi berhasil.
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-medal text-yellow-500 mr-2"></i> Donatur Terloyal (Top 5)
            </h3>
            <div class="space-y-4">
                @forelse($topDonors as $index => $donor)
                <div class="flex items-center justify-between p-3 {{ $index == 0 ? 'bg-yellow-50 border-yellow-100' : 'bg-gray-50 border-gray-100' }} border rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold mr-3 shadow-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $donor->nama }}</p>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider">Total Kontribusi</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-orange-600">Rp {{ number_format($donor->donasi_sum_nominal ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada data donatur.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Perlu Tindakan (Deadline Terdekat)
            </h3>
            <div class="space-y-3">
                @forelse($urgentPrograms as $up)
                <div class="flex items-start p-3 bg-red-50 border border-red-100 rounded-lg">
                    <div class="mr-3 mt-1 text-red-500">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-gray-800 line-clamp-1">{{ $up->nama_program }}</h4>
                        <p class="text-xs text-red-600 font-medium">Berakhir dalam {{ \Carbon\Carbon::parse($up->tenggat_waktu)->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('program.edit', $up->slug) }}" class="text-xs font-bold text-red-700 hover:underline">
                        Detail
                    </a>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="inline-block p-4 rounded-full bg-blue-50 text-blue-500 mb-3">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Semua program aman. <br> Tidak ada deadline dalam waktu dekat.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('donasiChart').getContext('2d');
        
        // Ambil data dari PHP Controller
        const chartData = @json($chartData);

        new Chart(ctx, {
            type: 'bar', // Bisa diganti 'line' jika ingin grafik garis
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Total Nominal (Rp)',
                    data: chartData,
                    backgroundColor: 'rgba(249, 115, 22, 0.8)', // Warna Orange Tailwind
                    borderColor: 'rgb(234, 88, 12)', // Orange sedikit lebih gelap
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda karena hanya 1 dataset
                    },
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
                        ticks: {
                            callback: function(value, index, values) {
                                if(value >= 1000000){
                                    return 'Rp ' + (value / 1000000) + ' Jt';
                                }
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection