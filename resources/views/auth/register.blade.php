<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/padi-lazismu.jpg') }}">
    <title>Lazismu Situbondo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8 mt-8">
            <div class="mb-4 flex justify-center">
                <img src="{{ asset('images/logo-lazismu.png') }}" alt="Logo Lazismu" class="h-16 w-auto object-contain">
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
            <h3 class="text-center text-2xl font-bold text-gray-800 mb-2">REGISTER</h3>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-6 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa fa-user-circle text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" name="nama" value="{{ old('nama') }}" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white focus:border-orange-500 transition duration-200 sm:text-sm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white focus:border-orange-500 transition duration-200 sm:text-sm" placeholder="nama@email.com" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Nomor Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa fa-phone text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white focus:border-orange-500 transition duration-200 sm:text-sm" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input type="password" name="password" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white focus:border-orange-500 transition duration-200 sm:text-sm" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input type="password" name="password_confirmation" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white focus:border-orange-500 transition duration-200 sm:text-sm" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200 transform active:scale-95">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-orange-600 hover:text-orange-500 transition duration-150">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="#" class="text-xs text-gray-400 hover:text-gray-600 transition">
                &copy; 2026 Lazismu Situbondo
            </a>
        </div>
    </div>

</body>
</html>