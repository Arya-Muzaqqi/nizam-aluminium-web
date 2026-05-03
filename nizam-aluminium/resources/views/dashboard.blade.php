@extends('layouts.app')

@section('title', 'Dasbor Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Kartu 1: Proyek Berjalan -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 p-6 flex items-center justify-between relative overflow-hidden group">
        <!-- Dekorasi Sudut -->
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform duration-300 group-hover:scale-110"></div>
        
        <div class="relative z-10">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Proyek Berjalan</p>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $activeJobs }}</h3>
        </div>
        <div class="relative z-10 w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner border border-blue-100 transform transition-transform duration-300 group-hover:rotate-6">
            💼
        </div>
    </div>

    <!-- Kartu 2: Uang Muka -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 p-6 flex items-center justify-between relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition-transform duration-300 group-hover:scale-110"></div>
        
        <div class="relative z-10">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Uang Muka (DP)</p>
            <h3 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($totalDP, 0, ',', '.') }}</h3>
        </div>
        <div class="relative z-10 w-14 h-14 bg-gradient-to-br from-green-100 to-green-50 text-green-500 rounded-2xl flex items-center justify-center text-2xl shadow-inner border border-green-100 transform transition-transform duration-300 group-hover:rotate-6">
            💵
        </div>
    </div>

    <!-- Kartu 3: Sisa Piutang -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 p-6 flex items-center justify-between relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform duration-300 group-hover:scale-110"></div>
        
        <div class="relative z-10">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sisa Piutang</p>
            <h3 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</h3>
        </div>
        <div class="relative z-10 w-14 h-14 bg-gradient-to-br from-red-100 to-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl shadow-inner border border-red-100 transform transition-transform duration-300 group-hover:rotate-6">
            💳
        </div>
    </div>
</div>

<!-- Area Tabel Terbaru -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-7 py-5 border-b border-gray-50 bg-white">
        <h3 class="font-bold text-gray-800">Pesanan Terbaru</h3>
    </div>
    
    @if($latestOrders->isEmpty())
        <div class="p-10 text-center flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
            <p class="text-sm font-medium text-gray-400">Belum ada data pesanan di database.</p>
        </div>
    @else
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-[11px] text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100 tracking-wider font-bold">
                <tr>
                    <th scope="col" class="px-7 py-4">Nama Pelanggan</th>
                    <th scope="col" class="px-7 py-4">Nama Proyek</th>
                    <th scope="col" class="px-7 py-4">Status</th>
                    <th scope="col" class="px-7 py-4">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestOrders as $order)
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition-colors duration-150">
                    <td class="px-7 py-4 font-bold text-gray-800">{{ $order->customer->name }}</td>
                    <td class="px-7 py-4 text-gray-600">{{ $order->project_name }}</td>
                    <td class="px-7 py-4">
                        <span class="px-3 py-1.5 {{ $order->status == 'completed' ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-700' }} text-[11px] font-bold rounded-full">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-7 py-4 font-extrabold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection