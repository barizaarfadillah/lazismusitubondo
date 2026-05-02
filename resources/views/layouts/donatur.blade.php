@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        
        <div class="w-full md:w-1/4">
            <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden mb-6">
                <div class="p-6 text-center">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-yellow-500 mb-4">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h6 class="font-bold text-gray-800 text-lg">{{ auth()->user()->nama}}</h6>
                </div>
                
                <div class="flex flex-col border-t border-gray-100 p-3 gap-1">
                    <a href="{{ route('donatur.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('donatur.dashboard') ? 'bg-yellow-400 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('donatur.riwayat') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('donatur.riwayat') ? 'bg-yellow-400 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Donasi Saya
                    </a>
                    <a href="{{ route('donatur.profil') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('donatur.profil') ? 'bg-yellow-400 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
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