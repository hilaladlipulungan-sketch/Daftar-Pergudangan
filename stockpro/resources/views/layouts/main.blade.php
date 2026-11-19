<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StockPro')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#2563EB',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="p-6 text-xl font-bold border-b border-slate-700">
            StockPro
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">dashboard</span>
                Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('products.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">inventory_2</span>
                Data Barang
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('categories.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">category</span>
                Kategori
            </a>
            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('suppliers.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">local_shipping</span>
                Supplier
            </a>
            <a href="{{ route('warehouses.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('warehouses.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">warehouse</span>
                Gudang
            </a>
            <a href="{{ route('stock-ins.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('stock-ins.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">move_to_inbox</span>
                Barang Masuk
            </a>
            <a href="{{ route('stock-outs.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('stock-outs.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">outbox</span>
                Barang Keluar
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('reports.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">bar_chart</span>
                Laporan
            </a>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('users.*') ? 'bg-slate-800' : '' }}">
                <span class="material-symbols-outlined text-lg">group</span>
                Manajemen User
            </a>
        </nav>
        <div class="p-4 border-t border-slate-700 space-y-1">
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('profile.*') ? 'bg-slate-800' : '' }}">
        <span class="material-symbols-outlined text-lg">settings</span>
        Profile & Settings
    </a>
    <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 rounded-lg hover:bg-slate-800 text-red-300 flex items-center gap-3">
                    <span class="material-symbols-outlined text-lg">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b px-8 py-3 flex justify-between items-center gap-6">
            {{-- Search bar --}}
            <div class="flex items-center gap-4 flex-1">
                <form action="{{ route('products.index') }}" method="GET" class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari barang, SKU, atau supplier..."
                        class="w-full bg-gray-100 border-none rounded-xl py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary outline-none"
                    >
                </form>
            </div>

            {{-- Right side: icons + version + user --}}
            <div class="flex items-center gap-5">
                <div class="relative">
                    <button type="button" class="material-symbols-outlined text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors">
                        notifications
                    </button>
                    @if (isset($lowStockCount) && $lowStockCount > 0)
                        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                    @endif
                </div>

                <button type="button" class="material-symbols-outlined text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors">
                    help_outline
                </button>

                <div class="h-8 w-px bg-gray-200"></div>

                <div class="text-right leading-tight">
                    <p class="text-sm font-medium text-gray-800">StockPro v1.0</p>
                    <p class="text-xs text-gray-400">Status: Online</p>
                </div>

                <div class="h-8 w-px bg-gray-200"></div>

                <span class="text-sm text-gray-500 whitespace-nowrap">
                    {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                </span>
            </div>
        </header>

        <div class="bg-white border-b px-8 py-3">
            <h1 class="text-lg font-semibold">@yield('page-title', 'Dashboard')</h1>
        </div>

        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

</div>

{{-- Toast Notifikasi (melayang, auto-dismiss) --}}
<div id="toastContainer" class="fixed top-6 right-6 z-[60] space-y-3 w-full max-w-sm">
    @if (session('success'))
        <div class="toast-item flex items-start gap-3 bg-white border-l-4 border-green-500 shadow-lg rounded-lg p-4">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            <p class="text-sm text-gray-700 flex-1">{{ session('success') }}</p>
            <button onclick="this.closest('.toast-item').remove()" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="toast-item flex items-start gap-3 bg-white border-l-4 border-red-500 shadow-lg rounded-lg p-4">
            <span class="material-symbols-outlined text-red-500">error</span>
            <p class="text-sm text-gray-700 flex-1">{{ session('error') }}</p>
            <button onclick="this.closest('.toast-item').remove()" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="toast-item flex items-start gap-3 bg-white border-l-4 border-red-500 shadow-lg rounded-lg p-4">
            <span class="material-symbols-outlined text-red-500">error</span>
            <div class="flex-1">
                <ul class="text-sm text-gray-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="this.closest('.toast-item').remove()" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif
</div>

{{-- Modal Konfirmasi Hapus (global, dipakai semua halaman) --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg max-w-sm w-full mx-4 p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-600">warning</span>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-500" id="deleteModalText">Yakin ingin menghapus data ini?</p>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100">
                Batal
            </button>
            <button type="button" onclick="confirmDeleteSubmit()" class="px-4 py-2 rounded-lg text-sm font-medium bg-red-600 text-white hover:bg-red-700">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let formToDelete = null;

    function openDeleteModal(form, itemName = 'data ini') {
        formToDelete = form;
        document.getElementById('deleteModalText').textContent = `Yakin ingin menghapus ${itemName}? Tindakan ini tidak bisa dibatalkan.`;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        return false;
    }

    function closeDeleteModal() {
        formToDelete = null;
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function confirmDeleteSubmit() {
        if (formToDelete) {
            formToDelete.submit();
        }
    }

    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });

    // Loading state otomatis untuk semua form saat submit
    document.addEventListener('submit', function (e) {
        const form = e.target;

        // Lewati form search (GET) di header, biar gak ikut kena spinner
        if (form.method.toLowerCase() === 'get') return;

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.disabled) {
            submitBtn.dataset.originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
            submitBtn.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    Memproses...
                </span>
            `;
        }
    });

    // Toast auto-dismiss setelah 4 detik
    document.querySelectorAll('.toast-item').forEach(function (toast, index) {
        setTimeout(function () {
            toast.style.transition = 'opacity 0.3s, transform 0.3s';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 4000 + (index * 300));
    });
</script>

@stack('scripts')

</body>
</html>