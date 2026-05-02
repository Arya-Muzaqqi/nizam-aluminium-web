@extends('layouts.app')

@section('title', 'Input Biaya Operasional')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto">
    <form action="{{ route('costs.store') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Alokasikan Biaya ke Proyek (Job Order)</label>
            <select name="order_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">-- Pilih Proyek yang Sedang Berjalan --</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} : {{ $order->project_name }} ({{ $order->customer->name }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Transaksi</label>
                <input type="date" name="cost_date" required value="{{ date('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Kategori Biaya</label>
                <select name="category" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="material">Bahan Baku (Aluminium, Kaca, dll)</option>
                    <option value="labor">Upah Tukang / Pekerja</option>
                    <option value="overhead">Operasional Lainnya (Bensin, Makan, dll)</option>
                </select>
            </div>
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Detail</label>
            <input type="text" name="description" required placeholder="Contoh: Beli Kaca Tempered 10mm di Toko A" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Nominal Pengeluaran (Rp)</label>
            <input type="number" name="amount" required min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('costs.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Batal</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Pengeluaran</button>
        </div>
    </form>
</div>
@endsection