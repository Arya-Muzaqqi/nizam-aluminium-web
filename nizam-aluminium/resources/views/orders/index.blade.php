@extends('layouts.app')

@section('title', 'Data Pesanan')

@section('content')
<div class="mb-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Daftar Pesanan</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola data proyek</p>
    </div>
    
    <a href="{{ route('orders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Pesanan Baru
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2 shadow-sm">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50">
        <form action="{{ route('orders.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Proyek..." class="pl-9 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>

            <select name="status" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2.5">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition w-full sm:w-auto shadow-sm">Filter</button>
            
            @if(request('search') || request('status'))
                <a href="{{ route('orders.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2.5 rounded-lg text-sm font-semibold transition border border-red-100 w-full sm:w-auto text-center">Reset</a>
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
                    <th class="px-6 py-4 font-bold text-right text-blue-600">Harga Penawaran</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4 text-center font-mono text-xs text-blue-600 font-bold">
                        #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800 block mb-0.5">{{ $order->project_name }}</span>
                        <span class="text-xs text-gray-500">{{ $order->customer->name ?? 'Pelanggan Dihapus' }} • {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d M Y') }}</span>
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
                        @if($order->status == 'ongoing')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide">Sedang Dikerjakan</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide">Selesai</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center gap-2">
                            
                            <a href="{{ route('orders.show', $order->id) }}" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition border border-blue-100" title="Lihat Detail Pesanan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini beserta rincian bahannya?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition border border-red-100" title="Batal / Hapus Pesanan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada data pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection