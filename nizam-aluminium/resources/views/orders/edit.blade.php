@extends('layouts.app')

@section('title', 'Perbarui Status & Pelunasan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto">
    
    <!-- Info Ringkas Pesanan -->
    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
        <h4 class="font-bold text-blue-800">Detail Pesanan: JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h4>
        <p class="text-sm text-blue-700 mt-1">Proyek: {{ $order->project_name }} ({{ $order->customer->name }})</p>
        <div class="mt-3 grid grid-cols-3 gap-4 text-sm">
            <div>
                <span class="block text-blue-500">Total Harga</span>
                <span class="font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div>
                <span class="block text-blue-500">Sudah Dibayar</span>
                <span class="font-bold text-green-600">Rp {{ number_format($total_paid, 0, ',', '.') }}</span>
            </div>
            <div>
                <span class="block text-blue-500">Sisa Tagihan</span>
                <span class="font-bold text-red-600">Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Ubah Status Proyek</label>
            <select name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="ongoing" {{ $order->status == 'ongoing' ? 'selected' : '' }}>Ongoing (Sedang Dikerjakan)</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai & Diserahkan)</option>
            </select>
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900">Input Nominal Pelunasan / Cicilan Baru (Rp)</label>
            <input type="number" name="new_payment" min="0" placeholder="Kosongkan jika hanya ingin mengubah status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @if($sisa_tagihan > 0)
                <p class="mt-1 text-xs text-red-500">*Pelanggan ini masih memiliki sisa tagihan sebesar Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}</p>
            @else
                <p class="mt-1 text-xs text-green-600">*Pesanan ini sudah lunas sepenuhnya.</p>
            @endif
        </div>
        
        <div class="flex justify-end space-x-3 mt-8">
            <a href="{{ route('orders.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Batal</a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Pembaruan</button>
        </div>
    </form>
</div>
@endsection