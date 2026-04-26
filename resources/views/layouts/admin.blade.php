<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/padi-lazismu.jpg') }}">
    <title>Lazismu Situbondo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>

<body class="bg-gray-50 font-sans flex min-h-screen overflow-x-hidden">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#D35400] text-white flex flex-col shadow-xl transform -translate-x-full md:translate-x-0 md:sticky md:top-0 md:h-screen transition-transform duration-300 ease-in-out flex-shrink-0">
        
        <div class="p-2 text-center border-b border-white/20 relative flex-shrink-0">
            <button onclick="toggleSidebar()" class="absolute top-4 right-4 text-white hover:text-gray-200 md:hidden">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <img src="{{ asset('images/logo-lazismu.png') }}" alt="Logo" class="h-16 mx-auto drop-shadow-md">
        </div>

        <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto no-scrollbar">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200 {{ request()->is('admin/dashboard') ? 'bg-white/20 font-bold shadow-inner' : '' }}">
                <i class="fa-solid fa-gauge w-6 text-center"></i>
                <span class="ml-2">Dashboard</span>
            </a>

            <div class="pt-4 pb-2 text-xs font-semibold text-orange-200 uppercase tracking-wider">Master Data</div>
            
            <a href="{{ route('kategori.index') }}" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200 {{ request()->is('admin/kategori*') ? 'bg-white/20 font-bold shadow-inner' : '' }}">
                <i class="fa-solid fa-tags w-6 text-center"></i>
                <span class="ml-2">Kelola Kategori</span>
            </a>

            <a href="{{ route('program.index') }}" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200 {{ request()->is('admin/program*') ? 'bg-white/20 font-bold shadow-inner' : '' }}">
                <i class="fa-solid fa-calendar-check w-6 text-center"></i>
                <span class="ml-2">Kelola Program</span>
            </a>

            <a href="{{ route('rekening.index') }}" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200 {{ request()->is('admin/rekening*') ? 'bg-white/20 font-bold shadow-inner' : '' }}">
                <i class="fa-solid fa-money-check w-6 text-center"></i>
                <span class="ml-2">Kelola Rekening</span>
            </a>

            <a href="#" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200">
                <i class="fa-solid fa-users w-6 text-center"></i>
                <span class="ml-2">Kelola Donatur</span>
            </a>

            <a href="#" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200">
                <i class="fa-solid fa-user-shield w-6 text-center"></i>
                <span class="ml-2">Kelola Admin</span>
            </a>

            <div class="pt-4 pb-2 text-xs font-semibold text-orange-200 uppercase tracking-wider">Transaksi</div>

            <a href="#" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200">
                <i class="fa-solid fa-hand-holding-dollar w-6 text-center"></i>
                <span class="ml-2">Verifikasi Donasi</span>
            </a>

            <div class="pt-4 pb-2 text-xs font-semibold text-orange-200 uppercase tracking-wider">Laporan</div>

            <a href="#" class="flex items-center p-2 rounded-xl hover:bg-white/20 transition duration-200">
                <i class="fa-solid fa-file-invoice-dollar w-6 text-center"></i>
                <span class="ml-2">Laporan Donasi</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/20 flex-shrink-0">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center p-3 text-white bg-[#A14000] hover:bg-slate-800 hover:text-white rounded-xl transition duration-200">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>
                    <span class="font-bold">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        
        <header class="bg-white shadow-sm border-b px-6 py-4 flex justify-between items-center z-30 sticky top-0">
            <div class="flex items-center">
                <button onclick="toggleSidebar()" class="mr-4 text-gray-500 hover:text-[#D35400] focus:outline-none md:hidden">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800 truncate">@yield('header_title', 'Dashboard')</h1>
            </div>
            
            <div class="flex items-center space-x-3 border px-4 py-2 rounded-full bg-gray-50 flex-shrink-0">
                <span class="text-sm font-semibold text-gray-700 hidden sm:block">{{ Auth::user()->nama ?? 'Admin' }}</span>
                <div class="h-8 w-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 md:p-8">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

</body>
</html>