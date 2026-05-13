@extends('layouts.app')

@section('title', 'Terima Pembayaran & Update Status')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('reports.receivables') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Pembayaran & Status Pengerjaan</h2>
        <p class="text-sm text-gray-500 mt-1">Catat penerimaan uang (DP/Cicilan) dan ubah status proyek jika sudah selesai.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-5 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex items-start gap-3">
    <svg class="w-6 h-6 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <div>
        <h3 class="font-bold">Berhasil!</h3>
        <p class="text-sm mt-1">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            
            <div class="mb-6 p-5 bg-blue-50 rounded-xl border border-blue-100 shadow-inner">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-extrabold text-blue-900 text-lg">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h4>
                    <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $order->status == 'ongoing' ? 'Sedang Dikerjakan' : 'Selesai & Diserahkan' }}
                    </span>
                </div>
                
                <p class="text-sm text-blue-800 font-medium border-b border-blue-200 pb-3 mb-3">Pelanggan: <span class="font-bold">{{ $order->customer->name ?? 'Pelanggan Dihapus' }}</span></p>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div class="bg-white p-3 rounded-lg border border-blue-50">
                        <span class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Tagihan (Deal)</span>
                        <span class="font-black text-gray-800 text-base">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-white p-3 rounded-lg border border-blue-50">
                        <span class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Sudah Dibayar</span>
                        <span class="font-black text-blue-600 text-base">Rp {{ number_format($total_paid, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-white p-3 rounded-lg border border-red-50">
                        <span class="block text-red-400 text-xs font-bold uppercase tracking-wider mb-1">Sisa Piutang</span>
                        <span class="font-black text-red-600 text-base">Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('receivables.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Status Pengerjaan</label>
                        <select name="status" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm">
                            <option value="ongoing" {{ $order->status == 'ongoing' ? 'selected' : '' }}>Masih Dikerjakan (Ongoing)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai / Barang Diserahkan</option>
                        </select>
                        <p class="mt-2 text-[11px] text-gray-500 leading-relaxed">Ubah status jika barang sudah terpasang/diserahkan ke pelanggan.</p>
                    </div>

                    <div class="bg-green-50 p-5 rounded-xl border border-green-100">
                        @if($sisa_tagihan > 0)
                            <label class="block mb-2 text-sm font-bold text-gray-700">Input Nominal Pembayaran (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-green-700 sm:text-sm font-bold">Rp</span>
                                </div>
                                <input type="number" name="new_payment" min="1" max="{{ $sisa_tagihan }}" placeholder="Kosongkan jika hanya ubah status" class="pl-10 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 shadow-sm">
                            </div>
                            <p class="mt-2 text-[11px] text-gray-500 leading-relaxed">Maksimal yang bisa diinput adalah sesuai Sisa Piutang (Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}).</p>
                        @else
                            <div class="flex flex-col items-center justify-center h-full pt-2">
                                <svg class="w-8 h-8 text-green-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm font-bold text-green-700 uppercase">Tagihan Lunas</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-8 py-3.5 shadow-lg flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Pembaruan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
            <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Histori Setoran Uang
            </h3>
            
            <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar pr-2">
                @forelse($payments as $payment)
                    <div class="bg-gray-50 border border-gray-100 p-3 rounded-lg flex justify-between items-center">
                        <div>
                            <p class="text-[11px] text-gray-500 font-semibold">{{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y - H:i') }}</p>
                            <p class="text-xs font-bold text-gray-700 mt-0.5">{{ $payment->payment_type }}</p>
                        </div>
                        <span class="font-black text-green-600 text-sm">+ Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-sm text-gray-400 font-medium">Belum ada pembayaran masuk.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection