@extends('layouts.app')

@section('title', 'Laporan Piutang')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold text-gray-800">Laporan Piutang Pelanggan</h2>
    <p class="text-sm text-gray-500 mt-1">Pantau sisa tagihan proyek yang belum dilunasi oleh pelanggan.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <!-- TOOLBAR -->
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
        
        <!-- Form Pencarian -->
        <form action="{{ route('reports.receivables') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Pelanggan / Proyek..." class="pl-9 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition whitespace-nowrap shadow-sm w-full sm:w-auto">Cari Tagihan</button>
            
            @if(request('search'))
                <a href="{{ route('reports.receivables') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2.5 rounded-lg text-sm font-semibold transition whitespace-nowrap text-center border border-red-100 w-full sm:w-auto">Reset</a>
            @endif
        </form>

        <!-- KOTAK INFO: Total Seluruh Piutang -->
        <div class="w-full md:w-auto flex-shrink-0 bg-red-50 border border-red-100 px-5 py-2.5 rounded-xl shadow-sm flex items-center justify-between md:justify-end gap-4">
            <div class="w-10 h-10 bg-red-200 rounded-lg flex items-center justify-center text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="text-right">
                <span class="text-[11px] font-extrabold text-red-400 uppercase tracking-widest block mb-0.5">Total Keseluruhan Piutang</span>
                <span class="text-xl font-black text-red-600 leading-none">Rp {{ number_format($receivables->sum('sisa_piutang'), 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Tabel Data Piutang -->
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 min-w-max">
            <thead class="text-[11px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100 tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Pelanggan & Proyek</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Total Tagihan</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center text-blue-600">Sudah Dibayar (DP)</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right bg-red-50/50 text-red-600">Sisa Piutang (Kurang)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receivables as $order)
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800 block mb-0.5">{{ $order->customer->name }}</span>
                        <span class="text-[11px] text-gray-500">{{ $order->project_name }} • <span class="text-blue-500 uppercase font-semibold">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></span>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center font-bold text-blue-600 bg-blue-50/20">Rp {{ number_format($order->total_paid, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-black text-red-600 text-right bg-red-50/30">
                        Rp {{ number_format($order->sisa_piutang, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-gray-500 font-medium">Bagus! Tidak ada pelanggan yang menunggak piutang saat ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection