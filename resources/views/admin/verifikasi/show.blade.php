@extends('layouts.admin')

@section('header_title', 'Detail Donasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.verifikasi.index') }}" class="text-gray-500 hover:text-orange-500 mr-4 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Detail Transaksi Donasi</h2>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-3xl mx-auto">
        
        <div class="mb-6 flex justify-between items-center pb-4 border-b border-gray-100">
            <div>
                <p class="text-sm text-gray-500">Kode Transaksi</p>
                <p class="text-lg font-mono font-bold text-gray-800">{{ ($donasi->kode_transaksi) }}</p>
            </div>
            <div>
                @if($donasi->status == 'Pending')
                    <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide"><i class="fas fa-clock mr-1"></i> Menunggu Verifikasi</span>
                @elseif($donasi->status == 'Berhasil')
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide"><i class="fas fa-check mr-1"></i> Berhasil</span>
                @else
                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide"><i class="fas fa-times mr-1"></i> Dibatalkan/Gagal</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3"><i class="fas fa-user mr-2"></i> Informasi Donatur</h3>
                <div class="space-y-2">
                    <p><span class="text-gray-500 block text-xs">Nama Lengkap</span> <span class="font-medium text-gray-800">{{ $donasi->user->nama ?? 'Anonim' }}</span></p>
                    <p><span class="text-gray-500 block text-xs">Email</span> <span class="font-medium text-gray-800">{{ $donasi->user->email ?? '-' }}</span></p>
                    <p><span class="text-gray-500 block text-xs">No. Telepon</span> <span class="font-medium text-gray-800">{{ $donasi->user->no_telp ?? '-' }}</span></p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3"><i class="fas fa-box-open mr-2"></i> Detail Donasi</h3>
                <div class="space-y-2">
                    <p><span class="text-gray-500 block text-xs">Program Tujuan</span> <span class="font-medium text-gray-800 line-clamp-1">{{ $donasi->program->nama_program ?? 'Program Tidak Ditemukan' }}</span></p>
                    <p><span class="text-gray-500 block text-xs">Tanggal Transaksi</span> <span class="font-medium text-gray-800">{{ $donasi->created_at->format('d F Y, H:i') }} WIB</span></p>
                    <p><span class="text-gray-500 block text-xs">Metode / Bank Tujuan</span> <span class="font-medium text-gray-800">{{ $donasi->rekening->nama_bank }} - {{ $donasi->rekening->no_rekening }}</span></p>
                </div>
            </div>
        </div>

        <div class="text-center py-6 bg-orange-50 rounded-lg border border-orange-100 mb-8">
            <p class="text-sm text-gray-500 mb-1">Total Nominal Donasi</p>
            <p class="text-4xl font-bold text-orange-600">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</p>
        </div>

        @if($donasi->status == 'Pending')
            <div class="border-t border-gray-100 pt-6 mt-6">
                <p class="text-sm font-bold text-gray-600 mb-4 text-center">Silakan periksa mutasi rekening sebelum melakukan verifikasi data ini.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <form action="{{ route('admin.verifikasi.tolak', $donasi->id_donasi) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Anda yakin ingin MENOLAK donasi ini? Status akan diubah menjadi Gagal.');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-600 hover:text-white transition font-medium">
                            <i class="fas fa-times-circle mr-2"></i> Tolak Donasi
                        </button>
                    </form>

                    <form action="{{ route('admin.verifikasi.terima', $donasi->id_donasi) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Anda yakin ingin MENERIMA donasi ini? Status akan diubah menjadi Berhasil.');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 shadow-md transition font-medium text-lg">
                            <i class="fas fa-check-circle mr-2"></i> Terima Donasi
                        </button>
                    </form>
                </div>
            </div>
            
        @elseif($donasi->status == 'Berhasil')
            <div class="border-t border-gray-100 pt-6 mt-6 text-center">
                <div class="mb-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 text-green-500 rounded-full mb-2">
                        <i class="fas fa-check text-xl"></i>
                    </div>
                    <p class="text-gray-800 font-bold text-lg">Donasi Telah Diverifikasi</p>
                    <p class="text-sm text-gray-500">Kirimkan kuitansi digital sebagai bentuk transparansi dan ucapan terima kasih.</p>
                </div>

                @php
                    // Logika Ekstraksi & Format Nomor HP Donatur
                    $no_telp = $donasi->user->no_telp ?? '';
                    if(!empty($no_telp)) {
                        // Hilangkan karakter selain angka
                        $no_telp = preg_replace('/[^0-9]/', '', $no_telp);
                        // Ubah 0 di depan jadi 62
                        if(substr($no_telp, 0, 1) == '0') $no_telp = '62' . substr($no_telp, 1);
                        
                        // Siapkan Variabel Pesan
                        $nominal_rp = 'Rp ' . number_format($donasi->nominal, 0, ',', '.');
                        $tgl_donasi = $donasi->created_at->locale('id')->translatedFormat('d F Y');
                        $nama_donatur = $donasi->is_anonim ? 'Hamba Allah' : ($donasi->user->nama ?? 'Donatur');
                        
                        // Rangkai Pesan (Kuitansi + Doa)
                        $pesan_wa = "Assalamu'alaikum Bapak/Ibu *$nama_donatur*, \n\n";
                        $pesan_wa .= "Alhamdulillah, kami dari *Lazismu Situbondo* menginformasikan bahwa donasi Anda telah kami terima dengan rincian:\n\n";
                        $pesan_wa .= "*ID Transaksi:* {$donasi->kode_transaksi}\n";
                        $pesan_wa .= "*Tanggal:* $tgl_donasi\n";
                        $pesan_wa .= "*Program:* {$donasi->program->nama_program}\n";
                        $pesan_wa .= "*Nominal:* *$nominal_rp*\n\n";
                        $pesan_wa .= "*Unduh Kuitansi Resmi:* \n" . route('donatur.riwayat.kuitansi', $donasi->kode_transaksi) . "\n\n";
                        $pesan_wa .= "Jazakumullah Khairan Katsiran. _Ajarakallahu fiimaa a'thoita wa baaraka fiimaa abqoita wa ja'alahu laka thohuuron._ \n";
                        $pesan_wa .= "(Semoga Allah memberikan pahala atas apa yang engkau berikan, dan memberikan berkah atas harta yang kau simpan, dan menjadikannya pembersih bagimu.)\n\n";
                        $pesan_wa .= "Wassalamu'alaikum Warahmatullahi Wabarakatuh.\n- *Admin Lazismu Situbondo*";
                        
                        // Encode ke URL wa.me
                        $link_wa = "https://wa.me/{$no_telp}?text=" . urlencode($pesan_wa);
                    }
                @endphp

                @if(!empty($no_telp))
                    <a href="{{ $link_wa }}" target="_blank" class="inline-flex items-center justify-center px-8 py-3 bg-[#25D366] text-white rounded-xl hover:bg-[#1DA851] shadow-md transition font-bold text-lg w-full sm:w-auto">
                        <i class="fab fa-whatsapp mr-2 text-xl"></i> Kirim Kuitansi via WA
                    </a>
                @else
                    <div class="inline-block p-4 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl text-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Peringatan:</strong> Tidak dapat mengirim kuitansi WA karena donatur ini tidak melengkapi/memiliki nomor HP di profilnya.
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection