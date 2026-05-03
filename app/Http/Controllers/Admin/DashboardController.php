<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman profil admin.
     */
    public function profil()
    {
        $user = auth()->user();
        return view('admin.profil', compact('user'));
    }

    /**
     * Memperbarui data profil admin.
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:user,email,'.$user->id_user.',id_user',
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $dataUpdate = [
            'nama'    => $request->nama,
            'email'   => $request->email,
            'no_telp' => $request->no_telp,
            'alamat'  => $request->alamat,
        ];

        // Jika password diisi, lakukan enkripsi
        if ($request->filled('password')) {
            $dataUpdate['password'] = bcrypt($request->password);
        }
        
        $user->update($dataUpdate);

        return redirect()->route('admin.profil')->with('success', 'Profil admin berhasil diperbarui!');
    }
}