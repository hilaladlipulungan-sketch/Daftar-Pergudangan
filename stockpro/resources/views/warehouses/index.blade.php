@extends('layouts.main')

@section('title', 'Gudang - StockPro')
@section('page-title', 'Gudang')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('warehouses.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Tambah Gudang
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nama Gudang</th>
                    <th class="px-6 py-3">Lokasi</th>
                    <th class="px-6 py-3">Kapasitas</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($warehouses as $warehouse)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">{{ $warehouse->name }}</td>
                        <td class="px-6 py-3">{{ $warehouse->location ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $warehouse->capacity ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="text-primary hover:underline">Edit</a>
                            <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="inline"
                                  onsubmit="return openDeleteModal(this, @js($warehouse->name));">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-gray-400 text-center">Belum ada data gudang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection