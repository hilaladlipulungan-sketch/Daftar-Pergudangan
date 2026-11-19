@extends('layouts.main')

@section('title', $product->name . ' - StockPro')
@section('page-title', 'Detail Barang')

@section('content')

    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-primary flex items-center gap-1">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Data Barang
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Info produk --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border p-6">
            <p class="text-xs text-gray-400 font-medium">{{ $product->code }}</p>
            <h2 class="text-xl font-semibold text-gray-900 mt-1">{{ $product->name }}</h2>

            <div class="mt-6 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Kategori</span>
                    <span class="font-medium">{{ $product->category->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Gudang</span>
                    <span class="font-medium">{{ $product->warehouse->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Harga</span>
                    <span class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Stok Saat Ini</span>
                    <span class="font-semibold {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $product->stock }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Stok Minimum</span>
                    <span class="font-medium">{{ $product->min_stock }}</span>
                </div>
            </div>

            @if ($product->stock <= $product->min_stock)
                <div class="mt-6 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">warning</span>
                    Stok menipis, segera lakukan restock.
                </div>
            @endif

            <div class="mt-6 flex gap-3">
                <a href="{{ route('products.edit', $product->id) }}" class="flex-1 text-center bg-primary text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Edit
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1"
                      onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-50 text-red-600 py-2 rounded-lg text-sm font-medium hover:bg-red-100">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Riwayat transaksi --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="font-semibold">Riwayat Barang Masuk</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Supplier</th>
                            <th class="px-6 py-3">Jumlah</th>
                            <th class="px-6 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($stockIns as $stockIn)
                            <tr>
                                <td class="px-6 py-3">{{ $stockIn->supplier->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-green-600 font-semibold">+{{ $stockIn->quantity }}</td>
                                <td class="px-6 py-3">{{ $stockIn->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-gray-400 text-center">Belum ada riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="font-semibold">Riwayat Barang Keluar</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Tujuan</th>
                            <th class="px-6 py-3">Jumlah</th>
                            <th class="px-6 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($stockOuts as $stockOut)
                            <tr>
                                <td class="px-6 py-3">{{ $stockOut->destination ?? '-' }}</td>
                                <td class="px-6 py-3 text-red-600 font-semibold">-{{ $stockOut->quantity }}</td>
                                <td class="px-6 py-3">{{ $stockOut->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-gray-400 text-center">Belum ada riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection