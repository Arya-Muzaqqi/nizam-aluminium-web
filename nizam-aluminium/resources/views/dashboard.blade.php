@extends('layouts.app')

@section('title', 'Dasbor Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Kartu 1 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyek Berjalan</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $activeJobs }}</h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-xl">💼</div>
    </div>

    <!-- Kartu 2 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Uang Muka (DP)</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalDP, 0, ',', '.') }}</h3>
        </div>
        <div class="w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-xl">💵</div>
    </div>

    <!-- Kartu 3 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sisa Piutang</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</h3>
        </div>
        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center text-xl">💳</div>
    </div>
</div>

<!-- Area Tabel -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-800">Pesanan Terbaru</h3>
    </div>
    
    @if($latestOrders->isEmpty())
        <div class="p-8 text-center text-gray-400 border-2 border-dashed border-gray-200 m-4 rounded-lg">
            Belum ada data pesanan di database.
        </div>
    @else
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Pelanggan</th>
                    <th scope="col" class="px-6 py-3">Nama Proyek</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestOrders as $order)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $order->customer->name }}</td>
                    <td class="px-6 py-4">{{ $order->project_name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection