@extends('layouts.admin')

@section('header_title', 'Pengaturan Profil')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Pengaturan Profil Admin</h3>
            <p class="text-sm text-gray-500">Kelola informasi akun dan keamanan Anda.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm flex items-start gap-3">
            <i class="fa-solid fa-circle-check text-green-600 mt-0.5"></i>
            <div>
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    <form action="{{ route('admin.profil.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition text-sm bg-white" required>
                    @error('nama')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition text-sm bg-white" required>
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition text-sm bg-white" placeholder="Contoh: 08123456789">
                    @error('no_telp')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div></div> <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition text-sm bg-white" placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2 border-t border-gray-100 pt-6 mt-4">
                    <h5 class="text-sm font-bold text-gray-700">Ubah Kata Sandi</h5>
                    <p class="text-xs text-gray-400">Isi bagian ini hanya jika Anda ingin mengubah kata sandi yang saat ini digunakan.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Password Baru</label>
                    <input type="password" name="password" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition text-sm bg-white" placeholder="Minimal 8 karakter">
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition text-sm bg-white" placeholder="Ulangi password baru">
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg shadow-orange-100 text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

</div>
@endsection