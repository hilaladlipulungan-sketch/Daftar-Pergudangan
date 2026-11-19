<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - StockPro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#2563EB' }
                }
            }
        }
    </script>
</head>
<body class="font-sans bg-white">

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        {{-- Panel kiri: branding --}}
        <div class="hidden lg:flex flex-col justify-between bg-slate-900 text-white p-12">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">inventory_2</span>
                </div>
                <span class="text-lg font-semibold">StockPro</span>
            </div>

            <div>
                <h1 class="text-3xl font-semibold leading-snug mb-3">
                    Mulai kelola inventaris dengan lebih rapi.
                </h1>
                <p class="text-slate-400 leading-relaxed">
                    Buat akun untuk mulai mencatat stok, transaksi, dan laporan tim kamu.
                </p>
            </div>

            <p class="text-sm text-slate-500">© {{ date('Y') }} StockPro. Internal use only.</p>
        </div>

        {{-- Panel kanan: form --}}
        <div class="flex items-center justify-center p-8">
            <div class="w-full max-w-sm">

                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900">Buat akun baru</h2>
                    <p class="text-gray-500 text-sm mt-1">Lengkapi data di bawah untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="Nama kamu"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@perusahaan.com"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <input id="password" type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
                        @error('password')
                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               placeholder="••••••••"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition">
                        @error('password_confirmation')
                            <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-primary text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">
                        Daftar
                    </button>

                </form>

                <p class="text-center text-gray-500 text-sm mt-6">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary hover:text-blue-700 font-medium">Masuk di sini</a>
                </p>

            </div>
        </div>

    </div>

</body>
</html>