@extends('layouts.public')

@section('title', 'Tentang Kami - Lazismu Situbondo')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">

    <div class="bg-lazismu py-20 lg:py-28">
        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center flex flex-col items-center gap-5">
            <img class="h-16 w-auto drop-shadow-md brightness-0 invert" src="{{ asset('images/Padi-Lazismu.png') }}" alt="Logo Lazismu">
            
            <h1 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Tentang Lazismu Situbondo</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 -mt-10 relative z-20">
        
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 md:p-12 mb-12">
            
                
                <div class="space-y-5 text-gray-600 text-lg leading-relaxed text-justify">
                    <p>
                        <strong class="text-lazismu font-bold text-xl">LAZISMU</strong> adalah lembaga zakat tingkat nasional yang berkhidmat dalam pemberdayaan masyarakat melalui pendayagunaan secara produktif dana zakat, infaq, wakaf dan dana kedermawanan lainnya baik dari perseorangan, lembaga, perusahaan dan instansi lainnya.
                    </p>
                    <p>
                        Didirikan oleh Pimpinan Pusat (PP) Muhammadiyah pada tanggal 4 Juli tahun 2002, yang selanjutnya dikukuhkan oleh Menteri Agama Republik Indonesia sebagai Lembaga Amil Zakat Nasional melalui SK No. 457/21 November 2002. Guna memenuhi ketentuan perundang-undangan RI, LAZISMU dikukuhkan kembali sebagai LAZNAS melalui SK Kemenag RI No. 730 Tahun 2016.
                    </p>

                    <div class="pt-2">
                        <h4 class="font-bold text-gray-900 text-lg mb-3">Latar Belakang Berdirinya LAZISMU:</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <span class="font-black text-lazismu shrink-0">Pertama:</span>
                                <span>Fakta Indonesia yang berselimut dengan kemiskinan yang masih meluas, kebodohan dan indeks pembangunan manusia yang sangat rendah. Semuanya berakibat dan sekaligus disebabkan tatanan keadilan sosial yang lemah.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="font-black text-lazismu shrink-0">Kedua:</span>
                                <span>Zakat diyakini mampu bersumbangsih dalam mendorong keadilan sosial, pembangunan manusia dan mampu mengentaskan kemiskinan. Sebagai negara berpenduduk muslim terbesar di dunia, Indonesia memiliki potensi zakat, infaq dan wakaf yang terbilang cukup tinggi. Namun, potensi yang ada belum dapat dikelola dan didayagunakan secara maksimal sehingga tidak memberi dampak yang signifikan bagi penyelesaian persoalan yang ada.</span>
                            </li>
                        </ul>
                    </div>

                    <p>
                        Berdirinya LAZISMU dimaksudkan sebagai institusi pengelola zakat dengan manajemen modern yang dapat menghantarkan zakat menjadi bagian dari penyelesai masalah <em>(problem solver)</em> sosial masyarakat yang terus berkembang.
                    </p>
                    <p>
                        Dengan budaya kerja amanah, profesional dan transparan, LAZISMU berusaha mengembangkan diri menjadi Lembaga Zakat terpercaya. Dan seiring waktu, kepercayaan publik semakin menguat.
                    </p>
                    <p>
                        Dengan spirit kreativitas dan inovasi, LAZISMU senantiasa memproduksi program-program pendayagunaan yang mampu menjawab tantangan perubahan dan problem sosial masyarakat yang berkembang.
                    </p>
                    <p>
                        Dalam operasional programnya, LAZISMU didukung oleh Jaringan Multi Lini, sebuah jaringan konsolidasi lembaga zakat yang tersebar di seluruh provinsi (berbasis kabupaten/kota) yang menjadikan program-program pendayagunaan LAZISMU mampu menjangkau seluruh wilayah Indonesia secara cepat, terfokus dan tepat sasaran.
                    </p>
                            
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-orange-100 text-lazismu rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <i class="fa-solid fa-eye text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">Visi Kami</h3>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Menjadi Lembaga Amil Zakat Terpercaya.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-orange-100 text-lazismu rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <i class="fa-solid fa-bullseye text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">Misi Kami</h3>
                <ul class="text-gray-600 text-lg leading-relaxed space-y-3">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check text-lazismu mt-1.5"></i>
                        <span>Meningkatkan pendayagunaan ZIS yang kreatif, inovatif, dan produktif.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check text-lazismu mt-1.5"></i>
                        <span>Meningkatkan pelayanan donatur.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check text-lazismu mt-1.5"></i>
                        <span>Optimalisasi pelayanan donatur (muzakki) dan penerima manfaat (mustahik).</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-gray-900 rounded-3xl shadow-xl overflow-hidden text-white flex flex-col md:flex-row mb-12">
            <div class="p-8 md:p-12 flex-1 flex flex-col justify-center">
                <h3 class="text-3xl font-black mb-6">Kunjungi Kantor Kami</h3>
                <p class="text-gray-400 mb-8 text-lg">
                    Pintu kami selalu terbuka untuk Anda yang ingin berkonsultasi seputar ZIS atau menyalurkan donasi secara langsung.
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot text-lazismu text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-lg text-white mb-1">Alamat</p>
                            <p class="text-gray-400 leading-relaxed">Jl. Cendrawasih RT 02 / RW 03, Linkungan DAM, Dawuhan, Kec. Situbondo, Kabupaten Situbondo, Jawa Timur 68311</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone text-lazismu text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-lg text-white mb-1">Telepon / WhatsApp</p>
                            <p class="text-gray-400">0852-3183-9321</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-2/5 min-h-[350px] bg-gray-800 relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.75980168704!2d114.00318407416438!3d-7.708903992308817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd729000671bc83%3A0x1ca8ff93d7028096!2sKPP%20Lazismu%20Situbondo%20(Lembaga%20Amil%20Zakat%20Nasional)!5e0!3m2!1sen!2sid!4v1778508176159!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </div>
</div>
@endsection