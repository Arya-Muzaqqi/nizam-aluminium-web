@extends('layouts.app')

@section('title', 'Edit Data Pengguna')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $user->name }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Peran (Role)</label>
            <select name="role" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Operasional Bengkel)</option>
                <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik / Laporan)</option>
            </select>
        </div>
        
        <hr class="my-6 border-gray-200">
        <p class="text-sm text-gray-500 mb-4">*Kosongkan kedua kolom password di bawah ini jika tidak ingin mengubah password.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                <input type="password" name="password" minlength="8" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" minlength="8" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-8">
            <a href="{{ route('users.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Batal</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Pembaruan</button>
        </div>
    </form>
</div>
@endsection