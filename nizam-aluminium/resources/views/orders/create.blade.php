@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 max-w-3xl mx-auto">
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="mb-2 md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Pilih Pelanggan</label>
                <select name="customer_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2 md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Nama Proyek / Deskripsi Pekerjaan</label>
                <input type="text" name="project_name" required placeholder="Contoh: Pintu Aluminium Rumah Bpk. Budi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Total Harga Kesepakatan (Rp)</label>
                <input type="number" name="total_price" required min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Nominal Uang Muka / DP (Rp)</label>
                <input type="number" name="dp_amount" min="0" placeholder="Kosongkan jika tidak ada DP" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-2 md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Pesanan Masuk</label>
                <input type="date" name="order_date" required value="{{ date('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

        </div>
        
        <div class="flex justify-end space-x-3 mt-8">
            <a href="{{ route('orders.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Batal</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Pesanan & DP</button>
        </div>
    </form>
</div>
@endsection