@extends('layouts.app')

@section('title', 'Cetak Laporan HPP')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold text-gray-800">Laporan HPP & Laba Rugi</h2>
    <p class="text-sm text-gray-500 mt-1">Pantau Harga Pokok Penjualan dan keuntungan per proyek.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
<!-- TOOLBAR -->
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
        <form action="{{ route('reports.jobCosting') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full">
            
            <div class="relative w-full sm:w-56">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Proyek..." class="pl-9 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            
            <!-- Filter Status -->
            <select name="status" class="w-full sm:w-36 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                <option value="all">Semua Status</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Proses</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>

            <!-- Filter Bulan (BARU) -->
            <input type="month" name="month" value="{{ request('month') }}" class="w-full sm:w-40 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" title="Pilih Bulan Laporan">

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap shadow-sm w-full sm:w-auto">Filter</button>
            
            @if(request('search') || (request('status') && request('status') != 'all') || request('month'))
                <a href="{{ route('reports.jobCosting') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap text-center border border-red-100 w-full sm:w-auto">Reset</a>
            @endif

            <div class="flex-1 hidden md:block"></div>

            <button type="submit" name="export" value="excel" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition shadow-md flex items-center justify-center w-full sm:w-auto transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </button>
        </form>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 min-w-max">
            <thead class="text-[11px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100 tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Job ID & Proyek</th>
                    <th scope="col" class="px-6 py-4 font-bold">Harga Jual</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Bahan Baku</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Upah</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center bg-red-50/50 text-red-500">Total HPP</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right bg-green-50/50 text-green-600">Laba Bersih</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800 block mb-0.5">{{ $order->project_name }}</span>
                        <span class="text-[11px] text-gray-500">{{ $order->customer->name }} • <span class="text-blue-500 uppercase">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">Rp {{ number_format($order->material_cost, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">Rp {{ number_format($order->labor_cost, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center font-bold text-red-500 bg-red-50/30">Rp {{ number_format($order->total_cost, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-extrabold text-green-600 text-right bg-green-50/30">
                        @if($order->profit < 0)
                            <span class="text-red-600">- Rp {{ number_format(abs($order->profit), 0, ',', '.') }}</span>
                        @else
                            Rp {{ number_format($order->profit, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada data yang sesuai dengan filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-50 bg-white">
        {{ $orders->links() }}
    </div>
</div>
@endsection