@extends('layouts.app')

@section('title', 'Data Penawaran & Harga Deal')

@section('content')
<div class="mb-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Penawaran & Kesepakatan Harga</h2>
        <p class="text-sm text-gray-500 mt-1">Pantau modal proyek (HPP) dan tetapkan harga kesepakatan akhir dengan pelanggan.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2 shadow-sm">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50">
        <form action="{{ route('offers.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Proyek..." class="pl-9 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition w-full sm:w-auto shadow-sm">Cari</button>
            
            @if(request('search'))
                <a href="{{ route('offers.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2.5 rounded-lg text-sm font-semibold transition border border-red-100 w-full sm:w-auto text-center">Reset</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 min-w-max">
            <thead class="text-[11px] text-gray-400 uppercase bg-white border-b border-gray-100 tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-bold text-center">ID</th>
                    <th class="px-6 py-4 font-bold">Proyek & Pelanggan</th>
                    <th class="px-6 py-4 font-bold text-right text-gray-500">Total Modal (HPP)</th>
                    <th class="px-6 py-4 font-bold text-right text-blue-600">Harga Kesepakatan</th>
                    <th class="px-6 py-4 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($offers as $order)
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4 text-center font-mono text-xs text-blue-600 font-bold">
                        #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800 block mb-0.5">{{ $order->project_name }}</span>
                        <span class="text-xs text-gray-500">{{ $order->customer->name ?? 'Pelanggan Dihapus' }}</span>
                    </td>
                    <td class="px-6 py-4 text-right font-medium text-gray-500">
                        Rp {{ number_format($order->total_hpp, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($order->harga_penawaran == 0)
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-[11px] font-bold whitespace-nowrap border border-red-200">Tahap Negosiasi</span>
                        @else
                            <span class="font-black text-gray-900 text-lg">Rp {{ number_format($order->harga_penawaran, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($order->harga_penawaran == 0)
                            <a href="{{ route('offers.edit', $order->id) }}" class="inline-flex items-center gap-1 p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition border border-red-100 text-xs font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Input Harga Deal
                            </a>
                        @else
                            <a href="{{ route('offers.edit', $order->id) }}" class="inline-flex items-center gap-1 p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition border border-blue-100 text-xs font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Harga Deal
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data penawaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $offers->links() }}
    </div>
</div>
@endsection