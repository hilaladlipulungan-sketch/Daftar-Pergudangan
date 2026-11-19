@extends('layouts.main')

@section('title', 'Supplier - StockPro')
@section('page-title', 'Supplier')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('suppliers.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Tambah Supplier
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Kontak</th>
                    <th class="px-6 py-3">Telepon</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($suppliers as $supplier)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">{{ $supplier->name }}</td>
                        <td class="px-6 py-3">{{ $supplier->contact_person ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $supplier->phone ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $supplier->email ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-primary hover:underline">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline"
                                  onsubmit="return openDeleteModal(this, @js($supplier->name));">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-gray-400 text-center">Belum ada data supplier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection