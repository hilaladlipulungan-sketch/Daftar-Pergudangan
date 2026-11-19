@extends('layouts.main')

@section('title', 'Tambah Kategori - StockPro')
@section('page-title', 'Tambah Kategori')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="name" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('categories.index') }}" class="px-6 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                    Batal
                </a>
            </div>

        </form>
    </div>

@endsection