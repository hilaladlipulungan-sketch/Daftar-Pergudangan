@extends('layouts.main')

@section('title', 'Manajemen User - StockPro')
@section('page-title', 'Manajemen User')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('users.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Tambah User
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-primary hover:underline">Edit</a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline"
                                      onsubmit="return openDeleteModal(this, @js($user->name));">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                                </form>
                            @else
                                <span class="text-gray-300 ml-2 cursor-not-allowed" title="Tidak bisa menghapus akun sendiri">Hapus</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-gray-400 text-center">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection