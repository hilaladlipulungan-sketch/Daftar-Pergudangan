@extends('layouts.main')

@section('title', 'Laporan - StockPro')
@section('page-title', 'Laporan')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap items-end gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi</label>
                <select name="type" class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="in" {{ $type == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="out" {{ $type == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700">
                Filter
            </button>
            <a href="{{ route('reports.index') }}" class="px-6 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Reset
            </a>
            <a href="{{ route('reports.print', request()->query()) }}" target="_blank" class="bg-slate-800 text-white px-6 py-2 rounded-lg font-medium hover:bg-slate-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">print</span>
                Cetak PDF
            </a>

        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <p class="text-sm text-gray-500">Total Barang Masuk</p>
            <p class="text-3xl font-bold text-green-600 mt-1">+{{ $totalIn }} <span class="text-base font-normal text-gray-500">unit</span></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <p class="text-sm text-gray-500">Total Barang Keluar</p>
            <p class="text-3xl font-bold text-red-600 mt-1">-{{ $totalOut }} <span class="text-base font-normal text-gray-500">unit</span></p>
        </div>
    </div>

    @if ($type == 'all' || $type == 'in')
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold">Barang Masuk</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Supplier</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Catatan</th>
                        <th class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($stockIns as $stockIn)
                        <tr>
                            <td class="px-6 py-3">{{ $stockIn->product->name }}</td>
                            <td class="px-6 py-3">{{ $stockIn->supplier->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-green-600 font-semibold">+{{ $stockIn->quantity }}</td>
                            <td class="px-6 py-3">{{ $stockIn->notes ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $stockIn->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-gray-400 text-center">Tidak ada data pada rentang ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if ($type == 'all' || $type == 'out')
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold">Barang Keluar</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Tujuan</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Catatan</th>
                        <th class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($stockOuts as $stockOut)
                        <tr>
                            <td class="px-6 py-3">{{ $stockOut->product->name }}</td>
                            <td class="px-6 py-3">{{ $stockOut->destination ?? '-' }}</td>
                            <td class="px-6 py-3 text-red-600 font-semibold">-{{ $stockOut->quantity }}</td>
                            <td class="px-6 py-3">{{ $stockOut->notes ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $stockOut->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-gray-400 text-center">Tidak ada data pada rentang ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

@endsection