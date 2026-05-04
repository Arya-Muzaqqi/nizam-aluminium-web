@extends('layouts.app')
@section('title', 'Edit Pelanggan')
@section('content')
<div class="mb-5"><h2 class="text-2xl font-extrabold text-gray-800">Edit Data Pelanggan</h2></div>
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-2xl">
    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pelanggan</label>
            <input type="text" name="name" value="{{ $customer->name }}" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp</label>
            <input type="text" name="phone" value="{{ $customer->phone }}" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" required>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
            <textarea name="address" rows="3" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5">{{ $customer->address }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold">Simpan Perubahan</button>
        <a href="{{ route('customers.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-bold ml-2">Batal</a>
    </form>
</div>
@endsection