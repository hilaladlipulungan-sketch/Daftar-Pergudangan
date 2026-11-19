@extends('layouts.main')

@section('title', 'Edit Supplier - StockPro')
@section('page-title', 'Edit Supplier')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Supplier</label>
                <input type="text" name="name" value="{{ $supplier->name }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                <input type="text" name="contact_person" value="{{ $supplier->contact_person }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                    <input type="text" name="phone" value="{{ $supplier->phone }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $supplier->email }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="address" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">{{ $supplier->address }}</textarea>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('suppliers.index') }}" class="px-6 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                    Batal
                </a>
            </div>

        </form>
    </div>

@endsection