@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.donatur.index') }}" class="text-gray-500 hover:text-orange-500 mr-4 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Detail Donatur</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:col-span-1">
            <div class="text-center mb-4">
                <div class="h-24 w-24 rounded-full bg-orange-100 text-orange-500 mx-auto flex items-center justify-center text-4xl font-bold mb-3">
                    {{ strtoupper(substr($donatur->nama, 0, 1)) }}
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $donatur->nama }}</h3>
                <p class="text-gray-500 text-sm">Donatur</p>
                
                <div class="mt-3">
                    @if($donatur->status_user == 'Aktif')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">AKTIF</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">NONAKTIF</span>
                    @endif
                </div>
            </div>

            <hr class="my-4 border-gray-100">

            <div class="space-y-3 text-sm">
                <div class="flex flex-col">
                    <span class="text-gray-500 text-xs">Email</span>
                    <span class="font-medium text-gray-800">{{ $donatur->email }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500 text-xs">No. WhatsApp/Telepon</span>
                    <span class="font-medium text-gray-800">{{ $donatur->no_telp ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500 text-xs">Tanggal Bergabung</span>
                    <span class="font-medium text-gray-800">{{ $donatur->created_at->format('d F Y') }}</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.donatur.edit', $donatur->id_user) }}" class="w-full block text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-edit mr-1"></i> Edit Data Donatur
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 md:col-span-2 flex flex-col">
            <div class="p-5 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <h4 class="text-lg font-bold text-gray-800"><i class="fas fa-history mr-2 text-orange-500"></i> Riwayat Donasi</h4>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-white text-gray-600 text-xs uppercase tracking-wider text-left border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Tanggal</th>
                            <th class="px-6 py-3 font-semibold">Program</th>
                            <th class="px-6 py-3 font-semibold">Nominal</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                        @forelse($riwayatDonasi as $donasi)
                            <tr>
                                <td class="px-6 py-4">{{ $donasi->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $donasi->program->nama_program ?? 'Program Tidak Ditemukan' }}
                                </td>
                                <td class="px-6 py-4">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($donasi->status == 'Berhasil')
                                        <span class="text-green-600 bg-green-50 px-2 py-1 rounded text-xs font-bold uppercase">Berhasil</span>
                                    @elseif($donasi->status == 'Pending')
                                        <span class="text-orange-600 bg-orange-50 px-2 py-1 rounded text-xs font-bold uppercase">Pending</span>
                                    @else
                                        <span class="text-red-600 bg-red-50 px-2 py-1 rounded text-xs font-bold uppercase">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
                                        <p>Belum ada riwayat donasi untuk akun ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection