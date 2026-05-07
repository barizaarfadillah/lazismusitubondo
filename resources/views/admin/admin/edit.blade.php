@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.admin.index') }}" class="text-gray-500 hover:text-orange-500 mr-4 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Admin</h2>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form action="{{ route('admin.admin.update', $admin->id_user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $admin->nama) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon/WhatsApp</label>
                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $admin->no_telp) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                @error('no_telp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <hr class="my-6 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password (Opsional)</h3>
            <p class="text-sm text-gray-500 mb-4">Biarkan kosong jika Anda tidak ingin mengubah password admin ini.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('password') border-red-500 @enderror">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                </div>
            </div>

            <div class="flex justify-end space-x-3 border-t border-gray-100 pt-5">
                <a href="{{ route('admin.admin.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition shadow-sm font-medium flex items-center">
                    <i class="fas fa-save mr-2"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection