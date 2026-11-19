@extends('layouts.main')

@section('title', 'Dashboard - StockPro')
@section('page-title', 'Dashboard')

@section('content')

{{-- ==================== STATISTIK ==================== --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

    <div class="bg-white rounded-xl shadow-sm p-6 border">
        <p class="text-sm text-gray-500">Total Produk</p>
        <p class="text-3xl font-bold text-primary mt-1">
            {{ $totalProducts }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border">
        <p class="text-sm text-gray-500">Total Kategori</p>
        <p class="text-3xl font-bold text-primary mt-1">
            {{ $totalCategories }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border">
        <p class="text-sm text-gray-500">Total Supplier</p>
        <p class="text-3xl font-bold text-primary mt-1">
            {{ $totalSuppliers }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border">
        <p class="text-sm text-gray-500">Total Gudang</p>
        <p class="text-3xl font-bold text-primary mt-1">
            {{ $totalWarehouses }}
        </p>
    </div>

</div>


{{-- ==================== PERINGATAN STOK MENIPIS ==================== --}}
<div class="bg-white rounded-xl shadow-sm border mb-8">

    <div class="px-6 py-4 border-b">
        <h2 class="font-semibold text-red-600">
            ⚠ Peringatan Stok Menipis
        </h2>
    </div>

    <table class="w-full text-sm">

        <thead class="bg-gray-50 text-left text-gray-500">
            <tr>
                <th class="px-6 py-3">Kode</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Stok Saat Ini</th>
                <th class="px-6 py-3">Stok Minimum</th>
            </tr>
        </thead>

        <tbody class="divide-y">

            @forelse ($lowStockProducts as $product)

                <tr class="bg-red-50">

                    <td class="px-6 py-3">
                        {{ $product->code }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $product->name }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $product->stock }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $product->min_stock }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="px-6 py-4 text-gray-400">
                        Semua stok produk aman.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- ==================== GRAFIK ==================== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- TREND KELUAR-MASUK STOK --}}
    <div class="bg-white rounded-xl shadow-sm border p-6">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h2 class="font-semibold text-lg">
                    Tren Keluar-Masuk Stok
                </h2>

                <p class="text-sm text-gray-500">
                    Laporan harian selama 14 hari terakhir
                </p>
            </div>

        </div>

        <canvas id="stockTrendChart" height="150"></canvas>

    </div>


    {{-- DISTRIBUSI KATEGORI --}}
    <div class="bg-white rounded-xl shadow-sm border p-6">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h2 class="font-semibold text-lg">
                    Distribusi Kategori
                </h2>

                <p class="text-sm text-gray-500">
                    Persentase produk berdasarkan kategori
                </p>
            </div>

        </div>

        <div class="flex justify-center">
            <div class="w-full max-w-sm">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

    </div>

</div>


{{-- ==================== AKTIVITAS TERKINI ==================== --}}
<div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">

    <div class="px-6 py-4 border-b flex justify-between items-center">

        <h2 class="font-semibold">
            Aktivitas Terkini
        </h2>

        <a href="{{ route('reports.index') }}"
           class="text-sm text-primary hover:underline">
            Lihat Semua Aktivitas
        </a>

    </div>


    <table class="w-full text-sm">

        <thead class="bg-gray-50 text-left text-gray-500">

            <tr>
                <th class="px-6 py-3">Waktu</th>
                <th class="px-6 py-3">Produk</th>
                <th class="px-6 py-3">SKU</th>
                <th class="px-6 py-3">Tipe</th>
                <th class="px-6 py-3">Jumlah</th>
                <th class="px-6 py-3">User</th>
            </tr>

        </thead>


        <tbody class="divide-y">

            @forelse ($recentActivities as $activity)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-3 text-gray-500">
                        {{ $activity['time']->format('H:i:s') }}
                    </td>

                    <td class="px-6 py-3 font-medium">
                        {{ $activity['product'] }}
                    </td>

                    <td class="px-6 py-3 text-gray-500">
                        {{ $activity['code'] }}
                    </td>

                    <td class="px-6 py-3">

                        <span
                            class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $activity['type'] == 'MASUK'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">

                            {{ $activity['type'] }}

                        </span>

                    </td>

                    <td
                        class="px-6 py-3 font-semibold
                        {{ $activity['type'] == 'MASUK'
                            ? 'text-green-600'
                            : 'text-red-600' }}">

                        {{ $activity['type'] == 'MASUK' ? '+' : '-' }}
                        {{ $activity['quantity'] }} Unit

                    </td>

                    <td class="px-6 py-3">
                        {{ $activity['user'] }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6"
                        class="px-6 py-4 text-gray-400 text-center">
                        Belum ada aktivitas.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- ==================== KAPASITAS GUDANG ==================== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

    @foreach ($warehouseCapacities as $warehouse)

        <div class="bg-white rounded-xl shadow-sm border p-6">

            <p class="text-sm text-gray-500 mb-1">
                {{ $warehouse['name'] }}
            </p>


            <p
                class="text-2xl font-bold
                {{ $warehouse['percentage'] >= 90
                    ? 'text-red-600'
                    : ($warehouse['percentage'] >= 70
                        ? 'text-orange-500'
                        : 'text-gray-900') }}">

                {{ $warehouse['percentage'] }}%

                <span class="text-sm font-normal text-gray-500">
                    Kapasitas Terisi
                </span>

            </p>


            <div class="w-full bg-gray-100 rounded-full h-2 mt-3">

                <div
                    class="h-2 rounded-full
                    {{ $warehouse['percentage'] >= 90
                        ? 'bg-red-500'
                        : ($warehouse['percentage'] >= 70
                            ? 'bg-orange-400'
                            : 'bg-primary') }}"
                    style="width: {{ $warehouse['percentage'] }}%">
                </div>

            </div>


            <p
                class="text-xs mt-2
                {{ $warehouse['percentage'] >= 90
                    ? 'text-red-600'
                    : ($warehouse['percentage'] >= 70
                        ? 'text-orange-500'
                        : 'text-green-600') }}">

                @if ($warehouse['percentage'] >= 90)

                    ⚠ Hampir Penuh

                @elseif ($warehouse['percentage'] >= 70)

                    ⚠ Kapasitas Tinggi

                @else

                    ✓ Kondisi Optimal

                @endif

            </p>

        </div>

    @endforeach

</div>

@endsection


{{-- ==================== CHART.JS ==================== --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

<script>

    // =========================================================
    // GRAFIK TREN KELUAR-MASUK STOK
    // =========================================================

    const stockTrendCtx = document.getElementById('stockTrendChart');

    new Chart(stockTrendCtx, {

        type: 'bar',

        data: {

            labels: @json($stockTrendLabels),

            datasets: [

                {
                    label: 'Barang Masuk',
                    data: @json($stockTrendMasuk),
                    backgroundColor: '#2563EB',
                    borderRadius: 4,
                },

                {
                    label: 'Barang Keluar',
                    data: @json($stockTrendKeluar),
                    backgroundColor: '#EF4444',
                    borderRadius: 4,
                }

            ]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    position: 'bottom'
                }

            },

            scales: {

                y: {
                    beginAtZero: true
                }

            }

        }

    });


    // =========================================================
    // DONUT CHART DISTRIBUSI KATEGORI
    // =========================================================

    const categoryCtx = document.getElementById('categoryChart');

    new Chart(categoryCtx, {

        type: 'doughnut',

        data: {

            labels: @json(
                $categoryDistribution->pluck('name')
            ),

            datasets: [

                {
                    label: 'Distribusi Produk',

                    data: @json(
                        $categoryDistribution->pluck('count')
                    ),

                    backgroundColor: [
                        '#2563EB',
                        '#10B981',
                        '#F59E0B',
                        '#EF4444',
                        '#8B5CF6',
                        '#EC4899',
                        '#14B8A6',
                        '#F97316',
                        '#6366F1',
                        '#84CC16'
                    ],

                    borderWidth: 2,

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: true,

            plugins: {

                legend: {
                    position: 'bottom'
                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            const total =
                                context.dataset.data.reduce(
                                    (sum, value) => sum + value,
                                    0
                                );

                            const value = context.raw;

                            const percentage =
                                total > 0
                                    ? Math.round((value / total) * 100)
                                    : 0;

                            return context.label +
                                ': ' +
                                value +
                                ' produk (' +
                                percentage +
                                '%)';

                        }

                    }

                }

            }

        }

    });

</script>

@endpush