@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Admin</h2>
        <a href="{{ route('admin.admin.create') }}" class="bg-[#D35400] text-white px-4 py-2 rounded-xl font-bold hover:bg-[#A14000] transition shadow-sm flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-user-plus mr-2"></i> Tambah Admin
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-t-lg shadow-sm border-b border-gray-200 p-4 flex justify-end">
        <form action="{{ route('admin.admin.index') }}" method="GET" class="w-full md:w-1/3 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email admin..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 text-sm">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <i class="fas fa-search"></i>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-b-lg shadow-sm overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider text-left">
                <tr>
                    <th class="px-6 py-4 border-b font-semibold">Nama Admin</th>
                    <th class="px-6 py-4 border-b font-semibold">Kontak</th>
                    <th class="px-6 py-4 border-b font-semibold">Hak Akses</th>
                    <th class="px-6 py-4 border-b font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 font-medium flex items-center">
                        <div class="h-8 w-8 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center font-bold mr-3">
                            {{ strtoupper(substr($admin->nama, 0, 1)) }}
                        </div>
                        {{ $admin->nama }}
                        @if(Auth::user()->id_user == $admin->id_user)
                            <span class="ml-2 bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold">ANDA</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-gray-800">{{ $admin->email }}</span>
                            <span class="text-xs text-gray-500">{{ $admin->no_telp ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($admin->id_user == 1)
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">Super Admin</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">Admin</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center space-x-3">
                        @if($admin->id_user == 1 && Auth::user()->id_user != 1)
                            <button type="button" class="text-gray-300 cursor-not-allowed" title="Akses Terkunci: Hanya Admin Utama yang dapat mengedit profil ini">
                                <i class="fas fa-lock"></i>
                            </button>
                        @else
                            <a href="{{ route('admin.admin.edit', $admin->id_user) }}" class="text-yellow-500 hover:text-yellow-700 transition" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endif
                        
                        @if(Auth::user()->id_user != $admin->id_user && $admin->id_user != 1)
                            <form action="{{ route('admin.admin.destroy', $admin->id_user) }}" method="POST" class="inline-block" onsubmit="return confirm('Peringatan: Menghapus admin bersifat permanen. Anda yakin ingin melanjutkan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus Admin">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <button type="button" class="text-gray-300 cursor-not-allowed" title="Akun ini dilindungi">
                                <i class="fas fa-shield-alt"></i>
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        Tidak ada data admin yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4 border-t border-gray-200">
            {{ $admins->appends(['search' => $search])->links() }}
        </div>
    </div>
</div>
@endsection