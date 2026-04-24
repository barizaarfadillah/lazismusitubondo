@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="bg-blue-100 p-4 rounded-xl text-blue-600 mr-4">
            <i class="fa-solid fa-wallet text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Donasi</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp 0</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="bg-orange-100 p-4 rounded-xl text-orange-600 mr-4">
            <i class="fa-solid fa-bullhorn text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Program Aktif</p>
            <h3 class="text-2xl font-bold text-gray-800">0</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="bg-green-100 p-4 rounded-xl text-green-600 mr-4">
            <i class="fa-solid fa-users text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Donatur</p>
            <h3 class="text-2xl font-bold text-gray-800">0</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="bg-red-100 p-4 rounded-xl text-red-600 mr-4">
            <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</p>
            <h3 class="text-2xl font-bold text-gray-800">0</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Aktivitas Donasi Terbaru</h3>
    <div class="text-center py-12">
        <i class="fa-solid fa-folder-open text-6xl text-gray-200 mb-4"></i>
        <p class="text-gray-400 font-medium">Belum ada data transaksi donasi saat ini.</p>
    </div>
</div>
@endsection