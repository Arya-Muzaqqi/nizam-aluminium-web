@extends('layouts.app')

@section('title', 'Tambah Pelanggan Baru')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto">
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
            <input type="text" name="name" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">No. Telepon / WhatsApp</label>
            <input type="text" name="phone" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat Lengkap</label>
            <textarea name="address" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('customers.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Batal</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Data</button>
        </div>
    </form>
</div>
@endsection