@extends('layouts.public')

@section('title', 'Konfirmasi Donasi - Lazismu Situbondo')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-2xl mx-auto px-4">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h1 class="text-2xl font-black text-gray-900 mb-2">Konfirmasi Donasi</h1>
            <p class="text-sm text-gray-500 mb-6">Pastikan data di bawah ini sudah benar sebelum melakukan konfirmasi.</p>

            <div class="border-b border-gray-100 pb-4 mb-4">
                <p class="text-xs text-gray-400 font-bold uppercase">Program Donasi</p>
                <h2 class="text-lg font-bold text-gray-800 mt-1">{{ $program->nama_program }}</h2>
            </div>

            <div class="border-b border-gray-100 pb-6 mb-6">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-3">Metode Pembayaran</p>
                
                <div class="p-5 bg-orange-50/30 border border-orange-100 rounded-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
                    
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center border border-gray-100 shadow-sm p-2 shrink-0 overflow-hidden">
                            @if(!empty($rekening->logo) || isset($rekening->logo))
                                <img src="{{ asset('storage/' . $rekening->logo) }}" alt="{{ $rekening->nama_bank }}" class="w-full h-full object-contain">
                            @else
                                <span class="font-black text-gray-800 text-[10px] text-center">{{ $rekening->nama_bank }}</span>
                            @endif
                        </div>
                        
                        <div>
                            <h4 class="font-black text-gray-800 text-sm md:text-base">{{ $rekening->nama_bank }}</h4>
                            <span class="text-[10px] text-gray-500 font-bold uppercase mt-1">{{ $rekening->no_rekening }} - {{ $rekening->atas_nama }}</span>
                        </div>
                    </div>                    
                </div>
                <div class="flex flex-col items-center justify-center pt-2 gap-3">
                    @if(!empty($rekening->qris) || isset($rekening->qris))
                        <div class="w-full h-full bg-white p-3 border border-gray-200 rounded-lg shadow-sm flex items-center justify-center">
                            <img src="{{ asset('storage/' . $rekening->qris) }}" alt="QRIS {{ $rekening->nama_bank }}" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col items-center gap-1 mt-1">
                            <span class="text-[10px] font-black text-lazismu tracking-widest uppercase">Scan QRIS untuk Pembayaran</span>
                            <span class="text-[9px] text-gray-400">Pastikan nominal sesuai dengan tagihan Anda</span>
                        </div>
                    @else
                        <div class="text-center text-xs text-gray-400 italic py-2">
                            <i class="fa-solid fa-circle-info mr-1"></i> QRIS tidak tersedia. Silakan lakukan transfer manual ke nomor rekening di atas.
                        </div>
                    @endif
                </div>
            </div>

            <div class="border-b border-gray-100 pb-4 mb-6 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Nominal Donasi</span>
                    <span class="font-bold text-lazismu">Rp {{ number_format($data_donasi['nominal'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Tampilkan Nama</span>
                    <span class="font-bold text-gray-800">
                        {{ $data_donasi['is_anonim'] ? 'Hamba Allah (Anonim)' : auth()->user()->nama ?? 'Donatur' }}
                    </span>
                </div>
                @if($data_donasi['doa'])
                    <div>
                        <span class="text-gray-500 text-sm block mb-1">Doa/Pesan:</span>
                        <p class="p-3 bg-gray-50 text-gray-700 text-sm rounded-lg italic">"{{ $data_donasi['doa'] }}"</p>
                    </div>
                @endif
            </div>

            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl mb-6 text-sm text-yellow-800 flex items-start gap-3">
                <i class="fa-solid fa-circle-info text-yellow-600 mt-1"></i>
                <div>
                    <span class="font-bold">Lakukan pembayaran segera.</span> Setelah mengklik tombol konfirmasi di bawah, pesanan akan tercatat dan Anda dapat melakukan transfer atau memindai QRIS yang tersedia.
                </div>
            </div>

            <form action="{{ route('donasi.store', $program->slug) }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <input type="hidden" name="nominal" value="{{ $data_donasi['nominal'] }}">
                <input type="hidden" name="id_rekening" value="{{ $rekening->id_rekening }}">
                <input type="hidden" name="doa" value="{{ $data_donasi['doa'] }}">
                <input type="hidden" name="is_anonim" value="{{ $data_donasi['is_anonim'] }}">

                <button type="submit" class="w-full bg-lazismu text-white py-3 rounded-xl font-bold hover:bg-lazismu_hover transition shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i> Konfirmasi Donasi
                </button>
                <a href="{{ route('donasi.create', $program->slug) }}" class="w-full text-center text-sm font-bold text-gray-400 hover:text-gray-600 py-2">
                    Batalkan / Ubah Rincian
                </a>
            </form>

        </div>
    </div>
</div>
@endsection