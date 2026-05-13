@extends('layouts.app')

@section('title', 'Tetapkan Harga Deal')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('offers.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Tetapkan Harga Deal (Penawaran)</h2>
        <p class="text-sm text-gray-500 mt-1">Negosiasikan harga dengan pelanggan dan kunci harga akhirnya di sini.</p>
    </div>
</div>

@if(session('error'))
<div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm flex items-start gap-3">
    <svg class="w-6 h-6 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
    <div>
        <h3 class="font-bold">Gagal Menyimpan!</h3>
        <p class="text-sm mt-1">{{ session('error') }}</p>
    </div>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl">
    
    <div class="mb-6 p-5 bg-slate-50 rounded-xl border border-slate-200 shadow-inner">
        <div class="flex justify-between items-center mb-4 border-b border-slate-200 pb-3">
            <div>
                <h4 class="font-extrabold text-slate-800 text-lg">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h4>
                <p class="text-sm text-slate-600 font-medium">Pelanggan: <span class="font-bold text-blue-600">{{ $order->customer->name ?? 'Pelanggan Dihapus' }}</span></p>
            </div>
            <p class="text-sm text-slate-600 font-medium">Proyek: <span class="font-bold">{{ $order->project_name }}</span></p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded-lg border border-slate-100">
                <span class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Modal Bahan & Upah (HPP)</span>
                <span class="font-black text-slate-800 text-xl">Rp {{ number_format($order->total_hpp, 0, ',', '.') }}</span>
            </div>
            <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                <span class="block text-red-500 text-xs font-bold uppercase tracking-wider mb-1">Batas Bawah Penawaran (+5%)</span>
                @php $batas_bawah = $order->total_hpp + ($order->total_hpp * 0.05); @endphp
                <span class="font-black text-red-600 text-xl">Rp {{ number_format($batas_bawah, 0, ',', '.') }}</span>
                <p class="text-[10px] text-red-400 mt-1">*Jangan berikan harga di bawah angka ini agar tidak rugi.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('offers.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 mb-6">
            <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Input Harga Kesepakatan Akhir
            </h3>
            
            <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">Harga Final yang Disetujui Pelanggan (Rp)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-blue-900 sm:text-lg font-black">Rp</span>
                    </div>
                    <input type="number" name="harga_penawaran" value="{{ $order->harga_penawaran > 0 ? $order->harga_penawaran : '' }}" min="{{ $batas_bawah }}" required class="pl-12 bg-white border-2 border-blue-400 text-blue-900 font-black text-xl rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-4 transition shadow-sm">
                </div>
                <p class="mt-2 text-xs text-gray-500 leading-relaxed">*Harga ini otomatis akan menjadi acuan total tagihan (Piutang) pelanggan.</p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
            <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-8 py-3.5 text-center transition shadow-lg flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Kunci Harga Kesepakatan
            </button>
        </div>
    </form>
</div>
@endsection