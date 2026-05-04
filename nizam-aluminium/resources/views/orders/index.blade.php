@extends('layouts.app')

@section('title', 'Pesanan & Tagihan')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold text-gray-800">Daftar Pesanan & Pembayaran</h2>
    <p class="text-sm text-gray-500 mt-1">Pantau proyek berjalan, status pembayaran DP, dan sisa tagihan.</p>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-5" role="alert">
    <span class="block sm:inline font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- TOOLBAR -->
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
        <form action="{{ route('orders.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Proyek atau Pelanggan..." class="pl-9 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>
            
            <select name="status" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-40 p-2.5 transition">
                <option value="">Semua Status</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing (Proses)</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
            </select>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition shadow-sm w-full sm:w-auto">Filter</button>
            @if(request('search') || request('status'))
                <a href="{{ route('orders.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-lg text-sm font-medium transition text-center border border-red-100 w-full sm:w-auto">Reset</a>
            @endif
        </form>

        <div class="w-full md:w-auto flex-shrink-0">
            <a href="{{ route('orders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center justify-center w-full md:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Input Pesanan Baru
            </a>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-[11px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100 tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Job ID & Proyek</th>
                    <th scope="col" class="px-6 py-4 font-bold">Total Harga</th>
                    <th scope="col" class="px-6 py-4 font-bold text-blue-600">Terbayar (DP/Cicilan)</th>
                    <th scope="col" class="px-6 py-4 font-bold text-red-500">Sisa Tagihan</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                    <th scope="col" class="px-6 py-4 text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    $total_paid = $order->payments->sum('amount');
                    $sisa_tagihan = $order->total_price - $total_paid;
                @endphp
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800 block mb-0.5">{{ $order->project_name }}</span>
                        <span class="text-[11px] text-gray-500">{{ $order->customer->name }} • <span class="text-blue-500 uppercase font-semibold">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-bold text-blue-600 bg-blue-50/20">Rp {{ number_format($total_paid, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-black text-red-500">
                        @if($sisa_tagihan > 0)
                            Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}
                        @else
                            <span class="text-green-500 font-bold">LUNAS</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($order->status == 'ongoing')
                            <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 font-bold text-[10px] uppercase tracking-wider rounded-md">Proses</span>
                        @else
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 font-bold text-[10px] uppercase tracking-wider rounded-md">Selesai</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center flex justify-center space-x-2">
                        <!-- TOMBOL EDIT & BAYAR -->
                        <a href="{{ route('orders.edit', $order->id) }}" class="text-yellow-600 hover:text-white border border-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-xs px-3 py-1.5 transition whitespace-nowrap">Edit / Bayar</a>
                        
                        <!-- TOMBOL HAPUS -->
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-white border border-red-200 hover:border-red-500 hover:bg-red-500 font-medium rounded-lg text-xs px-3 py-1.5 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-50 bg-white">
        {{ $orders->links() }}
    </div>
</div>
@endsection