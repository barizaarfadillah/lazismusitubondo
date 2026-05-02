@extends('layouts.donatur')

@section('konten_donatur')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('donatur.riwayat') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h4 class="text-2xl font-bold text-gray-800">Detail Donasi</h4>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Program Donasi</span>
                    @if($donasi->status == 'Berhasil')
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Donasi Berhasil</span>
                    @elseif($donasi->status == 'Pending')
                        <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold">Menunggu Verifikasi</span>
                    @else
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Donasi Gagal</span>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $donasi->program->nama_program }}</h2>
                <p class="text-gray-500 text-sm">Terima kasih atas kebaikan Anda. Semoga menjadi amal jariyah yang terus mengalir.</p>
            </div>

            <div class="border border-gray-100 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-100">
                    <h5 class="font-bold text-gray-700 text-sm">Rincian Transaksi</h5>
                </div>
                <div class="p-6 space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Kode Transaksi</span>
                        <span class="font-mono font-bold text-gray-800">{{ $donasi->kode_transaksi }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tanggal Donasi</span>
                        <span class="text-gray-800">{{ \Carbon\Carbon::parse($donasi->created_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Metode Pembayaran</span>
                        <span class="text-gray-800">{{ $donasi->rekening->nama_bank}}</span>
                    </div>
                    <div class="border-t border-dashed border-gray-200 pt-4 flex justify-between items-center">
                        <span class="text-gray-900 font-bold text-lg">Total Donasi</span>
                        <span class="text-orange-500 font-bold text-2xl">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @if($donasi->status == 'Pending')
            <div class="bg-orange-50 rounded-xl p-6 border border-orange-100">
                <div class="flex items-center gap-2 mb-3 text-orange-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h5 class="font-bold">Donasi anda sedang diverifikasi</h5>
                </div>
                <p class="text-orange-700 text-xs leading-relaxed text-justify mb-4">
                    Jika belum melakukan pembayaran, silakan lakukan transfer sesuai nominal ke rekening berikut:
                </p>
                
                <div class="bg-white p-3 rounded-lg border border-orange-200 mb-4">
                    <p class="text-[10px] text-gray-400 uppercase font-bold">{{ $donasi->rekening->nama_bank }}</p>
                    <p class="text-lg font-bold text-gray-800 tracking-wider">{{ $donasi->rekening->no_rekening }}</p>
                    <p class="text-xs text-gray-600">a.n {{ $donasi->rekening->atas_nama }}</p>
                </div>
            </div>
            @elseif($donasi->status == 'Berhasil')
            <div class="bg-green-50 rounded-xl p-6 border border-green-100 mb-4">
                <div class="flex items-center gap-2 mb-3 text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h5 class="font-bold">Donasi anda berhasil</h5>
                </div>
                <p class="text-green-700 text-xs leading-relaxed text-justify mb-4">
                    Terima kasih atas kebaikan Anda. Donasi Anda telah kami terima dan akan segera disalurkan. Silahkan unduh kuitansi sebagai bukti transaksi resmi.
                </p>
            </div>

            <a href="{{ route('donatur.riwayat.kuitansi', $donasi->kode_transaksi) }}" class="flex items-center justify-center gap-2 w-full bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh Kuitansi
            </a>
            @elseif($donasi->status == 'Gagal')
            <div class="bg-red-50 rounded-xl p-6 border border-red-100">
                <div class="flex items-center gap-2 mb-3 text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h5 class="font-bold">Donasi anda gagal</h5>
                </div>
                <p class="text-red-700 text-xs leading-relaxed text-justify">
                    Anda belum melakukan pembayaran atau bukti pembayaran yang Anda unggah tidak sesuai. Silakan lakukan donasi ulang jika ingin kembali membantu program ini.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection