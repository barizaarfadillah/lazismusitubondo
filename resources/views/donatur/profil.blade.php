@extends('layouts.donatur')

@section('konten_donatur')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    
    <div class="mb-8">
        <h4 class="text-2xl font-bold text-gray-800">Profil Saya</h4>
        <p class="text-gray-500 text-sm">Kelola informasi data pribadi dan keamanan akun Anda.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    <form action="{{ route('donatur.profil.update') }}" method="POST" class="max-w-4xl">
        @csrf
        @method('PATCH')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6 bg-gray-50/50 border border-gray-100 rounded-xl">
            
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
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition text-sm bg-white" placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <div></div> <div class="md:col-span-2 border-t border-gray-200/50 pt-4 mt-2">
                <h5 class="text-sm font-bold text-gray-700">Ubah Kata Sandi (Opsional)</h5>
                <p class="text-xs text-gray-400">Isi bagian ini hanya jika Anda ingin mengganti kata sandi yang lama.</p>
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

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg shadow-orange-100 text-sm">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>

</div>
@endsection