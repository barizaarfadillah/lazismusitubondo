@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Donasi</h2>
        <p class="text-sm text-gray-500">Pantau rekapitulasi dana masuk berdasarkan periode dan program.</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form action="{{ route('admin.laporan.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-orange-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Pilih Program</label>
                    <select name="program_id" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-orange-500">
                        <option value="">Semua Program</option>
                        @foreach($programs as $p)
                            <option value="{{ $p->id_program }}" {{ $programId == $p->id_program ? 'selected' : '' }}>{{ $p->nama_program }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Pilih Donatur</label>
                    <select name="donatur_id" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-orange-500">
                        <option value="">Semua Donatur</option>
                        @foreach($donaturs as $d)
                            <option value="{{ $d->id_user }}" {{ $donaturId == $d->id_user ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4 flex justify-end gap-2 mt-2">
                    <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200">Reset</a>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm hover:bg-orange-600 font-medium">
                        <i class="fas fa-filter mr-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin.laporan.cetak', request()->query()) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 font-medium inline-block text-center">
                        <i class="fas fa-print mr-1"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-orange-500 rounded-lg p-6 text-white shadow-md">
            <p class="text-orange-100 text-sm font-medium mb-1">Total Dana Terkumpul</p>
            <h3 class="text-3xl font-bold">Rp {{ number_format($totalNominal, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <p class="text-gray-500 text-sm font-medium mb-1">Total Transaksi Donasi</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalTransaksi }} <small class="text-sm font-normal text-gray-400">Transaksi</small></h3>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider text-left border-b">
                <tr>
                    <th class="px-6 py-4 font-semibold">Tgl Transaksi</th>
                    <th class="px-6 py-4 font-semibold">Kode Transaksi</th>
                    <th class="px-6 py-4 font-semibold">Donatur</th>
                    <th class="px-6 py-4 font-semibold text-center">Kategori</th>
                    <th class="px-6 py-4 font-semibold">Program</th>
                    <th class="px-6 py-4 font-semibold text-right">Metode / Bank Tujuan</th>
                    <th class="px-6 py-4 font-semibold text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                @forelse($reports as $report)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $report->created_at->format('d/m/Y') }}</td>
                    
                    <td class="px-6 py-4">
                        <span class="font-mono text-gray-800 font-medium">{{ $report->kode_transaksi }}</span>
                    </td>
                    
                    <td class="px-6 py-4 font-medium">{{ $report->user->nama ?? 'Anonim' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $report->program->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="truncate w-48" title="{{ $report->program->nama_program ?? '-' }}">
                            {{ $report->program->nama_program ?? '-' }}
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <span class="text-gray-800 font-medium border border-gray-200 px-2 py-1 rounded text-xs bg-white">
                            {{ $report->rekening->nama_bank }} - {{ $report->rekening->no_rekening }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($report->nominal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                        Tidak ada data ditemukan untuk filter tersebut.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection