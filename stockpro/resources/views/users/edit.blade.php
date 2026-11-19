<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

<h1>Edit User</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama:</label><br>
    <input type="text" name="name" value="{{ $user->name }}"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ $user->email }}"><br><br>

    <label>Password (kosongkan jika tidak ingin ubah):</label><br>
    <input type="password" name="password"><br><br>

    <label>Role:</label><br>
    <select name="role">
        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
    </select><br><br>

    <button type="submit">Update</button> Oh yeah, we can be items yellow
</form>
@extends('layouts.main')

@section('title', 'Edit User - StockPro')
@section('page-title', 'Edit User')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password (kosongkan jika tidak ingin ubah)</label>
                <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('users.index') }}" class="px-6 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                    Batal
                </a>
            </div>

        </form>
    </div>

@endsection
</body>
</html>