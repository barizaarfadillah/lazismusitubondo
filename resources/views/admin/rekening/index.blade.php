@extends('layouts.admin')

@section('header_title', 'Kelola Rekening Bank')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Daftar Rekening Donasi</h3>
            <p class="text-sm text-gray-500">Kelola rekening bank dan QRIS untuk penerimaan donasi.</p>
        </div>
        <a href="{{ route('rekening.create') }}" class="bg-[#D35400] text-white px-4 py-2 rounded-xl font-bold hover:bg-[#A14000] transition shadow-sm flex items-center justify-center w-full sm:w-auto">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Rekening
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <i class="fa-solid fa-circle-check text-green-500 mt-0.5"></i>
                <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <div class="flex">
                        <i class="fa-solid fa-times-circle text-red-500 mt-0.5"></i>
                        <p class="ml-3 text-sm text-red-700 font-medium">{{ $error }}</p>
                    </div>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="text-gray-400 text-sm uppercase tracking-wider border-b">
                    <th class="p-4 font-semibold text-center w-16">No</th>
                    <th class="p-4 font-semibold text-left">Bank</th>
                    <th class="p-4 font-semibold text-left">Nomor Rekening</th>
                    <th class="p-4 font-semibold text-left">Atas Nama</th>
                    <th class="p-4 font-semibold text-center">QRIS</th>
                    <th class="p-4 font-semibold text-center w-24">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rekening as $item)
                <tr class="hover:bg-orange-50 transition">
                    <td class="p-4 text-center font-medium text-gray-600">{{ $loop->iteration }}</td>
                    
                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 flex-shrink-0 bg-white border border-gray-100 rounded-lg flex items-center justify-center p-1 shadow-sm">
                                @if($item->logo)
                                    <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo" class="max-h-full max-w-full object-contain">
                                @else
                                    <i class="fa-solid fa-building-columns text-gray-300 text-xl"></i>
                                @endif
                            </div>
                            <span class="font-bold text-gray-800">{{ $item->nama_bank }}</span>
                        </div>
                    </td>

                    <td class="p-4">
                        <span class="font-mono font-bold text-[#D35400] tracking-wider bg-orange-50 px-3 py-1 rounded-lg">
                            {{ $item->no_rekening }}
                        </span>
                    </td>

                    <td class="p-4 text-gray-700 font-medium">{{ $item->atas_nama }}</td>

                    <td class="p-4 text-center">
                        @if($item->qris)
                            <a href="{{ asset('storage/' . $item->qris) }}" target="_blank" class="inline-flex items-center text-[#D35400] hover:text-[#A14000] font-bold text-xs bg-orange-50 px-3 py-1.5 rounded-full transition border border-orange-100">
                                <i class="fa-solid fa-qrcode mr-1.5"></i> Lihat QRIS
                            </a>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak Ada</span>
                        @endif
                    </td>

                    <td class="p-4">
                        <div class="flex justify-center">
                            <a href="{{ route('rekening.edit', $item->id_rekening) }}" class="bg-blue-50 text-blue-500 h-9 w-9 rounded-lg hover:bg-blue-500 hover:text-white transition flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('rekening.destroy', $item->id_rekening) }}" method="POST" onsubmit="return confirm('Hapus rekening {{ $item->nama_bank }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-500 h-9 w-9 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center text-gray-400 italic">
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-money-check-dollar text-5xl mb-4 text-gray-200"></i>
                            <p>Belum ada rekening bank yang didaftarkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection