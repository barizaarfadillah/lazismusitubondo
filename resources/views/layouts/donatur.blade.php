@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        
        <div class="w-full md:w-1/4">
            <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden mb-6">
                <div class="p-6 text-center">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-yellow-500 mb-4">
                        <i class="fa-solid fa-user text-3xl"></i>
                    </div>
                    <h6 class="font-bold text-gray-800 text-lg">{{ auth()->user()->nama }}</h6>
                </div>
                
                <div class="flex flex-col border-t border-gray-100 p-3 gap-1">
                    <a href="{{ route('donatur.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('donatur.dashboard') ? 'bg-yellow-400 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-gauge-high w-5 h-5 mr-3 flex items-center justify-center"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('donatur.riwayat') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('donatur.riwayat') ? 'bg-yellow-400 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-file-invoice-dollar w-5 h-5 mr-3 flex items-center justify-center"></i>
                        Donasi Saya
                    </a>
                    <a href="{{ route('donatur.profil') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('donatur.profil') ? 'bg-yellow-400 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-user-gear w-5 h-5 mr-3 flex items-center justify-center"></i>
                        Setting Profil
                    </a>
                </div>
            </div>
        </div>
        
        <div class="w-full md:w-3/4">
            @yield('konten_donatur')
        </div>
        
    </div>
</div>
@endsection