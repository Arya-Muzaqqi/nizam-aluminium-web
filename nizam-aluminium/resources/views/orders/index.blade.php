@extends('layouts.app')

@section('title', 'Pesanan & Pembayaran DP')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-gray-700 text-lg font-semibold">Daftar Proyek Berjalan</h3>
    <a href="{{ route('orders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Buat Pesanan Baru
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th scope="col" class="px-6 py-4">Job ID</th>
                <th scope="col" class="px-6 py-4">Pelanggan</th>
                <th scope="col" class="px-6 py-4">Nama Proyek</th>
                <th scope="col" class="px-6 py-4">Total Harga</th>
                <th scope="col" class="px-6 py-4">Status</th>
                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-semibold text-gray-900">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4">{{ $order->customer->name }}</td>
                <td class="px-6 py-4">{{ $order->project_name }}</td>
                <td class="px-6 py-4 font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 {{ $order->status == 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800' }} text-xs rounded-full">{{ ucfirst($order->status) }}</span>
                </td>
                <td class="px-6 py-4 text-center flex justify-center space-x-2">
                    <a href="{{ route('orders.edit', $order->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-2 rounded-md text-xs font-medium">Ubah Status / Lunasi</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini? Pengeluaran dan DP yang terkait juga akan terhapus!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-md text-xs font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 border-dashed border-2 m-4">
                    Belum ada pesanan yang tercatat.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Area Pagination -->
    <div class="p-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection