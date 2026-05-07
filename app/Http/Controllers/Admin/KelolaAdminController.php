<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KelolaAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil data user yang merupakan admin (is_admin = 1)
        $query = User::where('is_admin', 1);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $admins = $query->latest()->paginate(10);

        return view('admin.admin.index', compact('admins', 'search'));
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'no_telp' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed', 
        ]);

        User::create([
            'nama' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
            'status' => 'aktif'
        ]);

        return redirect()->route('admin.admin.index')
                         ->with('success', 'Akun Admin baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = User::where('id_user', $id)->firstOrFail();

        // KEAMANAN 3: Cegah admin lain mengedit Admin Utama (ID 1)
        if ($admin->id_user == 1 && Auth::user()->id_user != 1) {
            return redirect()->route('admin.admin.index')
                             ->with('error', 'Akses Ditolak: Anda tidak memiliki izin untuk mengedit profil Admin Utama.');
        }

        return view('admin.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('id_user', $id)->firstOrFail();

        // KEAMANAN 3: Pencegahan ganda saat proses simpan data (menangkal bypass URL)
        if ($admin->id_user == 1 && Auth::user()->id_user != 1) {
            return redirect()->route('admin.admin.index')
                             ->with('error', 'Akses Ditolak: Tindakan ilegal terdeteksi.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $admin->id_user . ',id_user',
            'no_telp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nama' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admin.index')
                         ->with('success', 'Data Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = User::where('id_user', $id)->firstOrFail();

        // KEAMANAN 1: Jangan izinkan menghapus diri sendiri
        if (Auth::user()->id_user == $admin->id_user) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        // KEAMANAN 2: Jangan izinkan menghapus Admin Utama (ID=1)
        if ($admin->id_user == 1) {
            return redirect()->back()->with('error', 'Akun Admin Utama tidak dapat dihapus dari sistem.');
        }

        $admin->delete();

        return redirect()->route('admin.admin.index')
                         ->with('success', 'Akun Admin berhasil dihapus permanen.');
    }
}