@extends('layouts.main')

@section('title', 'Edit Barang - StockPro')
@section('page-title', 'Edit Barang')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang</label>
                <input type="text" name="code" value="{{ $product->code }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gudang</label>
                <select name="warehouse_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" {{ $product->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimum</label>
                    <input type="number" name="min_stock" value="{{ $product->min_stock }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('products.index') }}" class="px-6 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                    Batal
                </a>
            </div>

        </form>
    </div>

@endsection