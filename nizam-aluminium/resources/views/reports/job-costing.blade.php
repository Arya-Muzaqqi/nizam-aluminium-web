@extends('layouts.app')

@section('title', 'Laporan HPP & Laba Rugi (Job Costing)')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-gray-700 text-lg font-semibold">Job Order Costing — Profit / Loss per Project</h3>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th scope="col" class="px-6 py-4">Job ID</th>
                <th scope="col" class="px-6 py-4">Proyek & Pelanggan</th>
                <th scope="col" class="px-6 py-4 text-right">Nilai Proyek (Penjualan)</th>
                <th scope="col" class="px-6 py-4 text-right">Bahan Baku (Material)</th>
                <th scope="col" class="px-6 py-4 text-right">Upah (Labor)</th>
                <th scope="col" class="px-6 py-4 text-right">Laba Bersih</th>
                <th scope="col" class="px-6 py-4 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-semibold text-gray-900">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4">
                    <span class="font-medium text-gray-900 block">{{ $order->project_name }}</span>
                    <span class="text-xs text-gray-400">{{ $order->customer->name }}</span>
                </td>
                <td class="px-6 py-4 text-right font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-right text-red-500">- Rp {{ number_format($order->material_cost, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-right text-red-500">- Rp {{ number_format($order->labor_cost, 0, ',', '.') }}</td>
                
                <!-- Jika untung warna hijau, jika rugi/minus warna merah -->
                <td class="px-6 py-4 text-right font-bold {{ $order->profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Rp {{ number_format($order->profit, 0, ',', '.') }}
                </td>
                
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 {{ $order->status == 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800' }} text-xs rounded-full">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400 border-dashed border-2 m-4">
                    Belum ada data proyek untuk dihitung laba ruginya.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection