@extends('layouts.admin')

@section('header_title', 'Edit Data Donatur')

@section('content')
<div class="container mx-auto px-4 py-6 ">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.donatur.index') }}" class="text-gray-500 hover:text-orange-500 mr-4 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Donatur</h2>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form action="{{ route('admin.donatur.update', $donatur->id_user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $donatur->nama) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $donatur->email) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon/WhatsApp</label>
                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $donatur->no_telp) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                @error('no_telp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end space-x-3 border-t border-gray-100 pt-5">
                <a href="{{ route('admin.donatur.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-medium">
                    <i class="fas fa-save mr-2"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection