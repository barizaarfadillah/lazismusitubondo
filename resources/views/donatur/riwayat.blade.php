@extends('layouts.donatur')

@section('konten_donatur')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="mb-6">
        <h4 class="text-2xl font-bold text-gray-800">Donasi Saya</h4>
        <p class="text-gray-500 text-sm mt-1">Pantau riwayat dan status transaksi donasi Anda di sini.</p>
    </div>
    
    <div class="border-b border-gray-200 mb-2">
        <nav class="flex space-x-8" aria-label="Tabs">
            <a href="{{ route('donatur.riwayat', ['status' => 'menunggu']) }}" 
               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-base transition-colors {{ $statusTab == 'menunggu' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Menunggu verifikasi
            </a>
            
            <a href="{{ route('donatur.riwayat', ['status' => 'berhasil']) }}" 
               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-base transition-colors {{ $statusTab == 'berhasil' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Donasi berhasil
            </a>
            
            <a href="{{ route('donatur.riwayat', ['status' => 'gagal']) }}" 
               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-base transition-colors {{ $statusTab == 'gagal' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Donasi gagal
            </a>
        </nav>
    </div>

    <div class="flex flex-col">

        @forelse ($riwayatDonasi as $donasi)
            <div class="py-5 border-b border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center gap-4 hover:bg-gray-50 transition-colors px-2 rounded-lg">
                <div>
                    <div class="flex items-center gap-3 mb-1.5">
                        <h5 class="text-lg font-medium text-gray-900">{{ $donasi->program->nama_program}}</h5>
                        
                        @if ($donasi->status == 'Berhasil')
                            <span class="bg-green-100 text-green-600 px-3 py-0.5 rounded-full text-xs font-semibold tracking-wide">Sukses</span>
                        @endif
                        </div>
                    
                    <p class="text-sm text-gray-400">
                        {{ \Carbon\Carbon::parse($donasi->created_at)->translatedFormat('d F Y') }} | 
                        {{ $donasi->kode_transaksi }} | 
                        Rp {{ number_format($donasi->nominal, 0, ',', '.') }}
                    </p>
                </div>
                
                <div>
                    <a href="{{ route('donatur.riwayat.detail', $donasi->kode_transaksi) }}" class="inline-block text-center border border-gray-300 text-gray-600 px-5 py-2 rounded text-sm font-medium hover:bg-gray-100 transition-colors w-full md:w-auto">
                        Detail
                    </a>
                    @if ($donasi->status == 'Berhasil')
                        <a href="{{ route('donatur.riwayat.kuitansi', $donasi->kode_transaksi) }}" class="inline-flex text-center border border-gray-300 text-gray-600 px-5 py-2 rounded text-sm font-medium hover:bg-gray-100 transition-colors w-full md:w-auto">
                            Unduh Kuitansi
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-10 text-center">
                <div class="text-gray-300 mb-3">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h5 class="text-gray-500 font-medium">Belum ada donasi dengan status ini.</h5>
            </div>
        @endforelse

    </div>
</div>
@endsection