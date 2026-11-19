@extends('layouts.main')

@section('title', 'Profile & Settings - StockPro')
@section('page-title', 'Profile & Settings')

@section('content')

    <div class="max-w-2xl space-y-6">

        {{-- Info akun --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="font-semibold text-gray-900 mb-1">Informasi Akun</h2>
            <p class="text-sm text-gray-500 mb-5">Perbarui nama dan alamat email akun kamu.</p>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-600">Tersimpan.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Ubah password --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="font-semibold text-gray-900 mb-1">Ubah Password</h2>
            <p class="text-sm text-gray-500 mb-5">Pastikan akun kamu memakai password yang kuat.</p>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Saat Ini</label>
                    <input id="current_password" type="password" name="current_password"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('current_password', 'updatePassword')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                    <input id="password" type="password" name="password"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('password', 'updatePassword')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('password_confirmation', 'updatePassword')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Update Password
                </button>
            </form>
        </div>

        {{-- Hapus akun --}}
        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
            <h2 class="font-semibold text-red-700 mb-1">Hapus Akun</h2>
            <p class="text-sm text-gray-500 mb-5">Setelah akun dihapus, semua data terkait akan hilang secara permanen. Simpan data penting sebelum lanjut.</p>

            <button type="button" onclick="document.getElementById('confirm-delete-form').classList.toggle('hidden')"
                    class="bg-red-50 text-red-600 px-5 py-2 rounded-lg text-sm font-medium hover:bg-red-100">
                Hapus Akun Saya
            </button>

            <form id="confirm-delete-form" method="POST" action="{{ route('profile.destroy') }}" class="hidden mt-4 space-y-4"
                  onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.');">
                @csrf
                @method('DELETE')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1.5">Masukkan password untuk konfirmasi</label>
                    <input id="delete_password" type="password" name="password"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('password', 'userDeletion')
                        <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-red-700">
                    Konfirmasi Hapus Akun
                </button>
            </form>
        </div>

    </div>

@endsection