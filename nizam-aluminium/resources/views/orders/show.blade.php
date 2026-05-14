@extends('layouts.app')

@section('title', 'Detail Pesanan Proyek')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('orders.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Detail Pesanan #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h2>
        <p class="text-sm text-gray-500 mt-1">Rincian spesifikasi teknis dan kebutuhan material proyek.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Informasi Umum</h3>
            <div class="space-y-4">
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Proyek</span>
                    <p class="text-gray-800 font-bold text-lg leading-tight">{{ $order->project_name }}</p>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pelanggan</span>
                    <p class="text-blue-600 font-bold">{{ $order->customer->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal Pesan</span>
                    <p class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</p>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status Deal</span>
                    @if($order->harga_penawaran == 0)
                        <span class="inline-block mt-1 px-2 py-1 bg-red-100 text-red-600 text-[10px] font-bold rounded uppercase">Belum Deal</span>
                    @else
                        <span class="inline-block mt-1 px-2 py-1 bg-green-100 text-green-600 text-[10px] font-bold rounded uppercase">Sudah Deal</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-slate-800 p-6 rounded-xl shadow-lg text-white">
            <h3 class="font-bold text-slate-400 mb-4 border-b border-slate-700 pb-2 text-xs uppercase tracking-widest">Spesifikasi Teknis</h3>
            <p class="text-sm leading-relaxed whitespace-pre-line">{{ $order->spesifikasi_teknis }}</p>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">Rincian Penggunaan Material & Upah</h3>
            </div>
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-[10px] text-gray-400 uppercase font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3">Nama Item</th>
                        <th class="px-6 py-3 text-center">Kuantitas</th>
                        <th class="px-6 py-3 text-right">Harga Satuan</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($order->orderDetails as $detail)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-700">{{ $detail->masterHpp->nama_item ?? 'Item Dihapus' }}</p>
                            <span class="text-[10px] text-gray-400">{{ $detail->masterHpp->kategori ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center font-medium text-gray-600">
                            {{ $detail->kuantitas }} {{ $detail->masterHpp->satuan ?? '' }}
                        </td>
                        <td class="px-6 py-4 text-right text-gray-500">
                            Rp {{ number_format($detail->harga_satuan_saat_pesan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-gray-800">
                            Rp {{ number_format($detail->subtotal_hpp, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-xs">Total Modal (HPP)</td>
                        <td class="px-6 py-4 text-right font-black text-red-600 text-lg">
                            Rp {{ number_format($order->total_hpp, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection