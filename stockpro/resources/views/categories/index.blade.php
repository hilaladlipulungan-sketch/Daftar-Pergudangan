@extends('layouts.main')

@section('title', 'Kategori - StockPro')
@section('page-title', 'Kategori')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('categories.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-6 py-3">{{ $category->description ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-primary hover:underline">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline"
                                  onsubmit="return openDeleteModal(this, @js($category->name));">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-gray-400 text-center">Belum ada data kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection