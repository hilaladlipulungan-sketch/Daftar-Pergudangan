@extends('layouts.main')

@section('title', 'Data Barang - StockPro')
@section('page-title', 'Data Barang')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('products.create') }}"
           class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Tambah Barang
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Gudang</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3">Min. Stok</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse ($products as $product)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-3">
                            {{ $product->code }}
                        </td>

                        <td class="px-6 py-3 font-medium">
                            {{ $product->name }}
                        </td>

                        <td class="px-6 py-3">
                            {{ $product->category->name }}
                        </td>

                        <td class="px-6 py-3">
                            {{ $product->warehouse->name }}
                        </td>

                        <td class="px-6 py-3">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-3">
                            <span class="{{ $product->stock <= $product->min_stock ? 'text-red-600 font-semibold' : '' }}">
                                {{ $product->stock }}
                            </span>
                        </td>

                        <td class="px-6 py-3">
                            {{ $product->min_stock }}
                        </td>

                        <td class="px-6 py-3">

                            <a href="{{ route('products.show', $product->id) }}"
                               class="text-gray-600 hover:underline">
                                Detail
                            </a>

                            <a href="{{ route('products.edit', $product->id) }}"
                               class="text-primary hover:underline ml-2">
                                Edit
                            </a>

                            {{-- Form Hapus --}}
                            <form action="{{ route('products.destroy', $product->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return openDeleteModal(this, @js($product->name));">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:underline ml-2">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8"
                            class="px-6 py-4 text-gray-400 text-center">
                            Belum ada data barang.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

        <div class="px-6 py-4 border-t">
            {{ $products->links() }}
        </div>
    </div>

@endsection