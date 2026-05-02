@extends('layouts.app')

@section('title', 'Daftar Piutang Pelanggan')

@section('content')
<div class="mb-6">
    <h3 class="text-gray-700 text-lg font-semibold">Accounts Receivable (Piutang)</h3>
    <p class="text-sm text-gray-500">Daftar proyek yang pembayarannya belum mencapai 100%.</p>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th scope="col" class="px-6 py-4">Job ID</th>
                <th scope="col" class="px-6 py-4">Pelanggan</th>
                <th scope="col" class="px-6 py-4">No. WhatsApp</th>
                <th scope="col" class="px-6 py-4 text-right">Total Harga</th>
                <th scope="col" class="px-6 py-4 text-right">Sudah Dibayar (DP/Cicilan)</th>
                <th scope="col" class="px-6 py-4 text-right">Sisa Piutang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($receivables as $order)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-semibold text-gray-900">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->customer->name }}</td>
                <td class="px-6 py-4">{{ $order->customer->phone }}</td>
                <td class="px-6 py-4 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-right text-green-600">Rp {{ number_format($order->total_paid, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-right font-bold text-red-600">Rp {{ number_format($order->sisa_piutang, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 border-dashed border-2 m-4">
                    Mantap! Semua pesanan pelanggan sudah lunas. Tidak ada piutang.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection