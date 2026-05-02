@extends('layouts.donatur')

@section('konten_donatur')
<div class="mb-6">
    <h4 class="text-2xl font-bold text-gray-800">Ringkasan Akun</h4>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-8 text-center flex flex-col items-center">
        <div class="w-16 h-16 bg-yellow-400 text-white rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <span class="block text-gray-500 text-sm font-medium mb-1">Total Donasi</span>
        <h4 class="text-3xl font-bold text-gray-800 mb-1">Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</h4>
        <p class="text-gray-400 text-xs">Donasi Saya</p>
    </div>
    
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-8 text-center flex flex-col items-center">
        <div class="w-16 h-16 bg-yellow-400 text-white rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <span class="block text-gray-500 text-sm font-medium mb-1">Total Program</span>
        <h4 class="text-3xl font-bold text-gray-800 mb-1">{{ $totalProgram ?? 0 }}</h4>
        <p class="text-gray-400 text-xs">Program Donasi</p>
    </div>
</div>
@endsection