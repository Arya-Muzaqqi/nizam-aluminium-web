@extends('layouts.app')

@section('title', 'Edit Pesanan & Pembayaran')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold text-gray-800">Edit Pesanan & Pembayaran</h2>
    <p class="text-sm text-gray-500 mt-1">Perbarui detail pesanan, ubah status proyek, atau input pembayaran baru.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl">
    
    <!-- Info Ringkas Pesanan (Milik Anda yang bagus tetap dipertahankan) -->
    <div class="mb-6 p-5 bg-blue-50 rounded-xl border border-blue-100 shadow-inner">
        <div class="flex justify-between items-center mb-2">
            <h4 class="font-extrabold text-blue-900 text-lg">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h4>
            <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $order->status }}
            </span>
        </div>
        <p class="text-sm text-blue-800 font-medium border-b border-blue-200 pb-3 mb-3">Pelanggan: <span class="font-bold">{{ $order->customer->name }}</span></p>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
            <div class="bg-white p-3 rounded-lg border border-blue-50">
                <span class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Harga Asli</span>
                <span class="font-black text-gray-800 text-base">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="bg-white p-3 rounded-lg border border-blue-50">
                <span class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Sudah Dibayar</span>
                <span class="font-black text-blue-600 text-base">Rp {{ number_format($total_paid, 0, ',', '.') }}</span>
            </div>
            <div class="bg-white p-3 rounded-lg border border-red-50">
                <span class="block text-red-400 text-xs font-bold uppercase tracking-wider mb-1">Sisa Tagihan</span>
                <span class="font-black text-red-600 text-base">Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 border-b pb-2">1. Edit Data Proyek</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Nama Proyek</label>
                <input type="text" name="project_name" value="{{ $order->project_name }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Total Harga Keseluruhan (Rp)</label>
                <input type="number" name="total_price" value="{{ $order->total_price }}" required min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
                <p class="mt-1 text-xs text-gray-500">*Ubah jika ada kesepakatan harga baru.</p>
            </div>
        </div>

        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 border-b pb-2">2. Update Status & Pembayaran</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Status Proyek</label>
                <select name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
                    <option value="ongoing" {{ $order->status == 'ongoing' ? 'selected' : '' }}>Ongoing (Sedang Dikerjakan)</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Input Pelunasan / Cicilan Baru (Rp)</label>
                <input type="number" name="new_payment" min="0" placeholder="Kosongkan jika tidak ada" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
                @if($sisa_tagihan > 0)
                    <p class="mt-1 text-xs font-bold text-red-500">*Sisa tagihan: Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}</p>
                @else
                    <p class="mt-1 text-xs font-bold text-green-600">*Lunas. Tidak perlu input lagi.</p>
                @endif
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('orders.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-bold rounded-lg text-sm px-6 py-3 text-center transition">Batal</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-6 py-3 text-center transition shadow-md">Simpan Semua Perubahan</button>
        </div>
    </form>
</div>
@endsection