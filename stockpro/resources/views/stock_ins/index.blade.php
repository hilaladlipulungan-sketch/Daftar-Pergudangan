@extends('layouts.main')

@section('title', 'Barang Masuk - StockPro')
@section('page-title', 'Barang Masuk')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('stock-ins.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Tambah Barang Masuk
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-6 py-3">Produk</th>
                    <th class="px-6 py-3">Supplier</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Catatan</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($stockIns as $stockIn)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">{{ $stockIn->product->name }}</td>
                        <td class="px-6 py-3">{{ $stockIn->supplier->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-green-600 font-semibold">+{{ $stockIn->quantity }}</td>
                        <td class="px-6 py-3">{{ $stockIn->notes ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $stockIn->created_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-3">
                            <form action="{{ route('stock-ins.destroy', $stockIn->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini? Stok produk akan otomatis dikurangi kembali.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-gray-400 text-center">Belum ada data barang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection