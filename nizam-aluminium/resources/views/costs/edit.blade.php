@extends('layouts.app')
@section('title', 'Edit Pengeluaran')
@section('content')
<div class="mb-5"><h2 class="text-2xl font-extrabold text-gray-800">Edit Data Pengeluaran</h2></div>
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-2xl">
    <form action="{{ route('costs.update', $cost->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengeluaran</label>
            <input type="date" name="cost_date" value="{{ \Carbon\Carbon::parse($cost->cost_date)->format('Y-m-d') }}" class="bg-gray-50 border border-gray-200 text-sm rounded-lg block w-full p-2.5" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Proyek</label>
            <select name="order_id" class="bg-gray-50 border border-gray-200 text-sm rounded-lg block w-full p-2.5" required>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}" {{ $cost->order_id == $order->id ? 'selected' : '' }}>{{ $order->project_name }} ({{ $order->customer->name }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Biaya</label>
            <select name="category" class="bg-gray-50 border border-gray-200 text-sm rounded-lg block w-full p-2.5" required>
                <option value="material" {{ $cost->category == 'material' ? 'selected' : '' }}>Bahan Baku</option>
                <option value="labor" {{ $cost->category == 'labor' ? 'selected' : '' }}>Upah Tukang</option>
                <option value="overhead" {{ $cost->category == 'overhead' ? 'selected' : '' }}>Lain-lain</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Belanja (Contoh: Kaca 5mm / Gaji Tukang)</label>
            <input type="text" name="description" value="{{ $cost->description }}" class="bg-gray-50 border border-gray-200 text-sm rounded-lg block w-full p-2.5" required>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Uang (Rp)</label>
            <input type="number" name="amount" value="{{ $cost->amount }}" class="bg-gray-50 border border-gray-200 text-sm rounded-lg block w-full p-2.5" required min="0">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold">Simpan Perubahan</button>
        <a href="{{ route('costs.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-bold ml-2">Batal</a>
    </form>
</div>
@endsection