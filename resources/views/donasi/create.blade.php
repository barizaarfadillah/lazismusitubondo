@extends('layouts.public')

@section('title', 'Tunaikan Donasi - Lazismu Situbondo')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20 pt-8">
    <div class="max-w-3xl mx-auto px-4">

        <div class="bg-white rounded-t-[2rem] p-6 lg:p-8 border border-gray-100 border-b-0 flex items-center gap-4 lg:gap-6">
            <img src="{{ asset('storage/' . $program->banner) }}" alt="Banner" class="w-20 h-20 lg:w-24 lg:h-24 object-cover rounded-xl shadow-sm shrink-0">
            <div>
                <p class="text-xs text-gray-500 mb-1 font-bold uppercase tracking-widest">Anda akan berdonasi untuk:</p>
                <h1 class="text-lg lg:text-xl font-bold text-gray-800 leading-snug line-clamp-2">{{ $program->nama_program }}</h1>
            </div>
        </div>

        <form action="{{ route('donasi.konfirmasi', $program->slug) }}" method="POST" class="bg-white p-6 lg:p-8 rounded-b-[2rem] shadow-sm border border-gray-100 space-y-10">
            @csrf

            <div>
                <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-orange-100 text-lazismu flex items-center justify-center text-sm">1</span> 
                    Nominal Donasi
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                    <button type="button" onclick="setNominal(50000, this)" class="nominal-btn border-2 border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-lazismu hover:text-lazismu transition">Rp 50 Ribu</button>
                    <button type="button" onclick="setNominal(100000, this)" class="nominal-btn border-2 border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-lazismu hover:text-lazismu transition">Rp 100 Ribu</button>
                    <button type="button" onclick="setNominal(300000, this)" class="nominal-btn border-2 border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-lazismu hover:text-lazismu transition">Rp 300 Ribu</button>
                    <button type="button" onclick="setNominal(500000, this)" class="nominal-btn border-2 border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-lazismu hover:text-lazismu transition">Rp 500 Ribu</button>
                </div>
                
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-400">Rp</span>
                    <input type="number" id="nominal_input" name="nominal" required min="10000" 
                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-xl font-black rounded-xl focus:ring-lazismu focus:border-lazismu block pl-12 p-4 transition" 
                           placeholder="Nominal Lainnya (Min. 10.000)">
                </div>
            </div>

            <hr class="border-gray-100">

            <div>
                <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-orange-100 text-lazismu flex items-center justify-center text-sm">2</span> 
                    Metode Pembayaran
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($rekening as $rek)
                        <label class="cursor-pointer relative">
                            <input type="radio" name="id_rekening" value="{{ $rek->id_rekening }}" class="peer sr-only" required>
                            <div class="p-4 rounded-xl border-2 border-gray-100 hover:border-orange-200 peer-checked:border-lazismu peer-checked:bg-orange-50/50 transition flex items-center gap-4 group">
                                
                                <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center border border-gray-100 shrink-0 shadow-sm overflow-hidden p-1.5">
                                    {{-- Cek apakah data logo/gambar tersedia --}}
                                    @if($rek->logo) 
                                        <img src="{{ asset('storage/' . $rek->logo) }}" alt="{{ $rek->nama_bank }}" class="w-full h-full object-contain">
                                    @else
                                        {{-- Fallback (cadangan) jika logo belum diupload admin --}}
                                        <span class="font-black text-gray-800 text-[10px] text-center">{{ $rek->nama_bank }}</span>
                                    @endif
                                </div>
                                
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm group-hover:text-lazismu transition">{{ $rek->nama_bank }}</h4>
                                    <p class="text-xs text-gray-500 font-medium font-mono mt-1">{{ $rek->nomor_rekening }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">a.n {{ $rek->atas_nama }}</p>
                                </div>
                                
                                <i class="fa-solid fa-circle-check absolute top-1/2 -translate-y-1/2 right-4 text-lazismu opacity-0 peer-checked:opacity-100 transition text-xl bg-white rounded-full"></i>
                            </div>
                        </label>
                    @empty
                        <div class="col-span-full p-4 bg-yellow-50 border border-yellow-100 rounded-xl flex items-center gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-yellow-600"></i>
                            <p class="text-sm text-yellow-700 font-medium">Metode pembayaran belum diatur untuk program ini. Silakan hubungi admin.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <hr class="border-gray-100">

            <div>
                <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-orange-100 text-lazismu flex items-center justify-center text-sm">3</span> 
                    Data Donatur
                </h3>
                
                @auth
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-5 flex items-center gap-3">
                        <i class="fa-solid fa-circle-info text-blue-500 text-lg"></i>
                        <p class="text-sm text-blue-800 font-medium">Anda berdonasi menggunakan akun <strong>{{ Auth::user()->nama }}</strong>.</p>
                    </div>
                @endauth

                <label class="flex items-center gap-3 mb-6 cursor-pointer group w-max">
                    <div class="relative">
                        <input type="checkbox" name="is_anonim" value="1" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-lazismu"></div>
                    </div>
                    <span class="text-sm font-bold text-gray-700 group-hover:text-lazismu transition">Sembunyikan nama saya (Hamba Allah)</span>
                </label>

                @guest
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-lazismu focus:border-lazismu block p-3.5" placeholder="Contoh: Fulan" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest">Email / No. WhatsApp</label>
                            <input type="text" name="kontak" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-lazismu focus:border-lazismu block p-3.5" placeholder="Untuk info status donasi" required>
                        </div>
                    </div>
                @endguest
            </div>

            <hr class="border-gray-100">

            <div>
                <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-hands-praying text-lazismu"></i> Sertakan Doa (Opsional)
                </h3>
                <textarea name="doa" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-lazismu focus:border-lazismu block p-4" placeholder="Tulis doa untuk program ini, diri sendiri, atau keluarga tercinta..."></textarea>
            </div>

            <button type="submit" class="w-full bg-lazismu text-white py-4 rounded-xl font-black text-lg hover:bg-lazismu_hover transition shadow-xl shadow-orange-200 transform hover:-translate-y-1 flex items-center justify-center gap-3">
                Lanjutkan Pembayaran <i class="fa-solid fa-arrow-right"></i>
            </button>
            
            <p class="text-center text-xs text-gray-400 mt-4 font-bold uppercase tracking-widest">
                <i class="fa-solid fa-shield-halved mr-1"></i> Transaksi Aman & Terenkripsi
            </p>
        </form>
    </div>
</div>

<script>
    function setNominal(amount, btn) {
        // Isi input dengan angka
        document.getElementById('nominal_input').value = amount;
        
        // Reset warna semua tombol
        document.querySelectorAll('.nominal-btn').forEach(el => {
            el.classList.remove('border-lazismu', 'text-lazismu', 'bg-orange-50', 'shadow-sm');
            el.classList.add('border-gray-200', 'text-gray-600');
        });

        // Beri warna khusus pada tombol yang diklik
        btn.classList.remove('border-gray-200', 'text-gray-600');
        btn.classList.add('border-lazismu', 'text-lazismu', 'bg-orange-50', 'shadow-sm');
    }
</script>
@endsection