<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/padi-lazismu.jpg') }}">
    <title>@yield('title', 'Lazismu Situbondo - Berbagi Kebaikan')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lazismu: '#D35400',
                        lazismu_hover: '#A14000',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex-shrink-0 flex items-center cursor-pointer" onclick="window.location.href='/'">
                    <img class="h-10 md:h-12 w-auto" src="{{ asset('images/logo-lazismu.png') }}" alt="Logo Lazismu">
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-lazismu font-bold text-sm transition duration-300">
                        Program Donasi
                    </a>

                    <div class="h-6 w-px bg-gray-200"></div>

                    @guest
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-lazismu font-bold text-sm transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="bg-lazismu text-white px-6 py-2.5 rounded-full font-bold text-sm hover:bg-lazismu_hover transition shadow-md shadow-orange-200">
                                Daftar
                            </a>
                        </div>
                    @else
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center focus:outline-none transform transition hover:scale-105 group">
                                <div class="h-8 w-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                                </div>
                                <i class="fa-solid fa-chevron-down text-[10px] ml-2 text-gray-400 group-hover:text-lazismu"></i>
                            </button>

                            <div id="userDropdown" class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl py-2 border border-gray-100 ring-1 ring-black ring-opacity-5 z-[100] animate-in fade-in slide-in-from-top-2 duration-200">
                                <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 rounded-t-2xl">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Masuk Sebagai</p>
                                    <p class="text-sm font-bold text-gray-800 truncate" title="{{ Auth::user()->nama }}">
                                        {{ Auth::user()->nama ?? 'Donatur Lazismu' }}
                                    </p>
                                    <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                
                                <div class="py-1">
                                    <a href="{{ route('donatur.dashboard') }}" class="flex items-center px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-lazismu transition">
                                        <div class="w-8">
                                            <i class="fa-solid fa-gauge-high"></i>
                                        </div>
                                        <span>Dashboard</span>
                                    </a>
                                </div>

                                <div class="border-t border-gray-50 mt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition font-medium">
                                            <div class="w-8">
                                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                            </div>
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>

                <div class="md:hidden flex items-center">
                    <button onclick="toggleMobileMenu()" class="text-gray-600 hover:text-lazismu focus:outline-none p-2 rounded-md">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>

            </div>
        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-xl z-40">
            <div class="px-4 pt-3 pb-6 space-y-2">
                <a href="{{ url('/') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:text-lazismu hover:bg-orange-50 transition">
                    <i class="fa-solid fa-box-open w-6 text-center mr-2 text-gray-400"></i> Program Donasi
                </a>

                @guest
                    <div class="border-t border-gray-100 pt-3 mt-2 grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}" class="block text-center px-4 py-2.5 rounded-xl text-sm font-bold text-gray-700 border border-gray-200 hover:border-lazismu hover:text-lazismu transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="block text-center px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-lazismu hover:bg-lazismu_hover transition">
                            Daftar
                        </a>
                    </div>
                @else
                    <div class="border-t border-gray-100 pt-4 mt-2">
                        <div class="flex items-center px-4 mb-4 bg-gray-50 py-3 rounded-xl">
                            <div class="h-10 w-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-base mr-3 shrink-0">
                                {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->nama ?? 'Donatur Lazismu' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <a href="{{ route('donatur.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:text-lazismu hover:bg-orange-50 transition mb-1">
                            <i class="fa-solid fa-gauge-high w-6 text-center mr-2 text-gray-400"></i> Dashboard
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-bold text-red-600 hover:bg-red-50 transition">
                                <i class="fa-solid fa-arrow-right-from-bracket w-6 text-center mr-2 text-red-400"></i> Keluar
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 pt-8 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-4">
                
                <div class="space-y-6">
                    <img class="h-14 w-auto" src="{{ asset('images/logo-lazismu.png') }}" alt="Logo Lazismu">
                    <p class="text-gray-500 text-sm leading-relaxed">
                        LAZISMU adalah lembaga zakat nasional dengan SK Menag No. 90 Tahun 2022, yang berkhidmat dalam pemberdayaan masyarakat melalui pendayagunaan dana zakat, infaq, wakaf dan dana kedermawanan lainnya baik dari perseorangan, lembaga, perusahaan dan instansi lainnya. Lazismu tidak menerima segala bentuk dana yang bersumber dari kejahatan. UU RI No. 8 Tahun 2010 Tentang Pencegahan dan Pemberantasan Tindak Pidana Pencucian Uang
                    </p>
                </div>

                <div>
                    <h4 class="text-gray-800 font-black text-sm uppercase tracking-widest mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-lazismu shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <span class="text-gray-500 leading-relaxed">
                                Kantor Lazismu Situbondo<br>
                                Jl. PB. Sudirman No. 123, Situbondo, Jawa Timur
                            </span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-lazismu shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span class="text-gray-500 font-medium">(0338) 123456</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-lazismu shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <span class="text-gray-500 font-medium">info@lazismu-situbondo.org</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-gray-800 font-black text-sm uppercase tracking-widest mb-6">Media Sosial</h4>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-lazismu hover:bg-lazismu hover:text-white transition shadow-sm">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-lazismu hover:bg-lazismu hover:text-white transition shadow-sm">
                            <i class="fa-brands fa-instagram text-base"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-lazismu hover:bg-lazismu hover:text-white transition shadow-sm">
                            <i class="fa-brands fa-facebook-f text-base"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-lazismu hover:bg-lazismu hover:text-white transition shadow-sm">
                            <i class="fa-brands fa-tiktok text-base"></i>
                        </a>
                    </div>
                    <p class="text-gray-400 text-xs mt-6 leading-relaxed">
                        Ikuti perkembangan program dan aktivitas kami melalui kanal media sosial resmi.
                    </p>
                </div>

            </div>

            <div class="pt-4 border-t border-gray-400 flex flex-col md:flex-row justify-center items-center gap-4">
                <p class="text-gray-400 text-xs font-medium">
                    © 2026 Lazismu Situbondo.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Toggle untuk Dropdown Profil di Desktop
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Toggle untuk Menu Mobile (Hamburger)
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        // Menutup dropdown desktop jika user klik di luar area
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const relative = document.querySelector('.relative');
            
            if (dropdown && relative && !relative.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>