<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Donasi - {{ $donasi->kode_transaksi }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/padi-lazismu.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 flex justify-center font-sans text-gray-800">

    <div class="max-w-4xl w-full">
        <div class="mb-4 flex justify-end no-print">
            <a href="{{ route('donatur.riwayat') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600 transition">Kembali</a>
            
            <button onclick="unduhPDF()" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh PDF
            </button>
        </div>

        <div id="area-kuitansi" class="bg-white p-10 shadow-lg relative overflow-hidden">
            
            <div class="absolute bottom-0 left-0 w-72 pointer-events-none z-0">
                <img src="{{ asset('images/footer-lazismu.png') }}" alt="Dekorasi Footer Lazismu" class="w-full h-auto opacity-90">
            </div>
            
            <div class="border-t-2 border-black w-full mb-6 relative z-10"></div>

            <div class="text-right mb-6 relative z-10">
                <h1 class="text-4xl font-black tracking-widest text-black">KUITANSI</h1>
                <p class="text-sm mt-1">
                    {{ \Carbon\Carbon::parse($donasi->created_at)->translatedFormat('l, d F Y') }}
                </p>
            </div>

            <div class="flex relative z-10">
                
                <div class="w-1/3 pr-6 flex flex-col items-center text-center">
                    
                    <div class="mb-2 flex flex-col items-center">
                        <img src="{{ asset('images/lazismu.png') }}" alt="Logo Lazismu" class="h-16 w-auto object-contain">
                        
                        <div class="text-[10px] font-bold">Lembaga Amil Zakat Nasional</div>
                        <div class="text-xs font-bold">SK. Menteri Agama RI No. 90 tahun 2022</div>
                    </div>

                    <div class="border-t border-dashed border-black w-full mt-2 mb-2"></div>
                    <div class="text-sm tracking-wider">{{ $donasi->kode_transaksi }}</div>
                    <div class="border-b border-dashed border-black w-full mt-2 mb-2"></div>
                    
                    <h3 class="font-bold text-sm tracking-widest mt-2 mb-2">LAZISMU - KAB. SITUBONDO</h3>

                    <div class="border-t border-dashed border-black w-full mb-4"></div>
                    
                    <p class="text-xs leading-relaxed text-justify">
                        Teriring doa semoga Allah SWT memberi pahala atas apa yang engkau berikan, memberikan barokah atas apa yang masih ada di tanganmu dan menjadikannya pembersih bagimu. Aamiin
                    </p>
                </div>

                <div class="w-0.5 bg-black mx-6 rounded-sm" style="height: 250px; min-height: 300px;"></div>

                <div class="w-2/3 pl-2 text-sm">
                    <p class="mb-4 italic font-semibold">Bismillahirrahmanirrahim <span class="not-italic font-normal">dengan ini saya</span></p>

                    <table class="w-full mb-8">
                        <tbody>
                            <tr class="h-8">
                                <td class="w-32 align-top">Nama</td>
                                <td class="w-4 align-top">:</td>
                                <td class="font-semibold align-top">{{ auth()->user()->nama ?? '-' }}</td>
                            </tr>
                            <tr class="h-8">
                                <td class="align-top">NPWP</td>
                                <td class="align-top">:</td>
                                <td class="align-top">-</td>
                            </tr>
                            <tr class="h-8">
                                <td class="align-top">No HP</td>
                                <td class="align-top">:</td>
                                <td class="align-top">{{ auth()->user()->no_telp ?? '-' }}</td>
                            </tr>
                            <tr class="h-8">
                                <td class="align-top">Metode</td>
                                <td class="align-top">:</td>
                                <td class="align-top">Mutasi Bank</td>
                            </tr>
                            <tr class="h-8">
                                <td class="align-top">Bank</td>
                                <td class="align-top">:</td>
                                <td class="align-top">{{ $donasi->rekening->nama_bank}} - {{ $donasi->rekening->no_rekening ?? '' }} an. {{ $donasi->rekening->atas_nama}}</td>
                            </tr>
                            <tr class="h-8">
                                <td class="align-top">Alamat</td>
                                <td class="align-top">:</td>
                                <td class="align-top">{{ auth()->user()->alamat ?? '-' }}</td>
                            </tr>
                            <tr class="h-8">
                                <td class="align-top">Telah Menunaikan</td>
                                <td class="align-top">:</td>
                                <td class="align-top font-semibold">{{ $donasi->program->kategori->nama_kategori }} - {{ $donasi->program->nama_program }}</td>
                            </tr>
                            <tr class="h-8">
                                <td class="align-top">Senilai</td>
                                <td class="align-top">:</td>
                                <td class="align-top font-bold">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-between text-center mt-8 px-8">
    
                        <div class="flex flex-col items-center justify-end">
                            <p class="mb-2 text-sm">Penerima,</p>
                            
                            <img src="{{ asset('images/ttd-lazismu.png') }}" alt="Tanda Tangan Penerima" class="h-24 w-auto object-contain mix-blend-multiply">
                            
                            <p class="font-semibold mt-1 text-sm">( Admin Lazismu )</p>
                        </div>
                        
                        <div class="flex flex-col items-center justify-start">
                            <p class="mb-2 text-sm">Penyetor,</p>
                            
                            <div class="h-24 w-full"></div>
                            
                            <p class="font-semibold text-sm mt-1">( {{ auth()->user()->nama ?? 'Donatur' }} )</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function unduhPDF() {
            // Ambil elemen yang ingin dijadikan PDF
            const element = document.getElementById('area-kuitansi');
            
            // Konfigurasi PDF
            const opt = {
                margin:       0.5,
                filename:     'Kuitansi_{{ $donasi->kode_transaksi }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true }, // scale 2 agar resolusi PDF tinggi/tidak pecah
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' } // orientation landscape agar proporsional
            };

            // Proses generate dan download
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>