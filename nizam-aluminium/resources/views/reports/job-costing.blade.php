@extends('layouts.app')

@section('title', 'Laporan Analisis Laba')

@section('content')
<div class="mb-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Laporan HPP & Analisis Laba</h2>
        <p class="text-sm text-gray-500 mt-1">Pantau Harga Pokok Penjualan dan margin keuntungan aktual per proyek.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50">
        <form action="{{ route('reports.jobCosting') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
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
                <a href="{{ route('reports.jobCosting') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2.5 rounded-lg text-sm font-semibold transition border border-red-100 w-full sm:w-auto text-center">Reset</a>
            @endif
        </form>

        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Excel
        </button>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 min-w-max">
            <thead class="text-[11px] text-gray-400 uppercase bg-white border-b border-gray-100 tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-bold">JOB ID & Proyek</th>
                    <th class="px-6 py-4 font-bold text-right text-gray-800">Harga Kesepakatan (Deal)</th>
                    <th class="px-6 py-4 font-bold text-right text-gray-500">Modal Material</th>
                    <th class="px-6 py-4 font-bold text-right text-gray-500">Modal Upah</th>
                    <th class="px-6 py-4 font-bold text-right text-red-600 bg-red-50/50">Total HPP</th>
                    <th class="px-6 py-4 font-bold text-right text-green-600 bg-green-50/50">Laba Bersih</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $order)
                @php
                    // Logika Cerdas: Memisahkan biaya bahan/aksesoris dengan upah tenaga kerja
                    $biaya_material = 0;
                    $biaya_upah = 0;

                    foreach($order->orderDetails as $detail) {
                        if($detail->masterHpp && $detail->masterHpp->kategori == 'Upah Tenaga') {
                            $biaya_upah += $detail->subtotal_hpp;
                        } else {
                            $biaya_material += $detail->subtotal_hpp;
                        }
                    }

                    // Hitung Laba Bersih
                    $laba_bersih = $order->total_price - $order->total_hpp;
                @endphp
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800 block mb-0.5">{{ $order->project_name }}</span>
                        <span class="text-xs text-gray-500">{{ $order->customer->name ?? 'Dihapus' }} • <span class="text-blue-500 font-semibold">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></span>
                    </td>
                    
                    <td class="px-6 py-4 text-right font-black text-gray-900 text-base">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    
                    <td class="px-6 py-4 text-right text-gray-500">
                        Rp {{ number_format($biaya_material, 0, ',', '.') }}
                    </td>
                    
                    <td class="px-6 py-4 text-right text-gray-500">
                        Rp {{ number_format($biaya_upah, 0, ',', '.') }}
                    </td>
                    
                    <td class="px-6 py-4 text-right font-bold text-red-600 bg-red-50/30">
                        Rp {{ number_format($order->total_hpp, 0, ',', '.') }}
                    </td>
                    
                    <td class="px-6 py-4 text-right font-black text-green-600 bg-green-50/30 text-base">
                        Rp {{ number_format($laba_bersih, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada data laporan laba/rugi untuk proyek yang sudah deal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $reports->links() }}
    </div>
</div>
@endsection