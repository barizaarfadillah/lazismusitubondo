<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Jalankan Validasi
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user,email'],
            'no_telp' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], 
        ], [
            // 2. Kustomisasi Pesan Error (Bahasa Indonesia)
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'email.email' => 'Format alamat email tidak valid.',
            'required' => ':attribute wajib diisi.'
        ]);

        // 3. Jika validasi lolos, buat user baru
        try {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'password' => Hash::make($request->password),
                'is_admin' => false,
                'status_user' => 'Aktif',
            ]);

            Auth::login($user);

            return redirect('/donatur/dashboard')->with('success', 'Selamat, akun Anda berhasil dibuat!');

        } catch (\Exception $e) {
            // Penanganan jika terjadi error database tak terduga
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'])->withInput();
        }
    }
}