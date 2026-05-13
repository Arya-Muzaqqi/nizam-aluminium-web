@extends('layouts.app')

@section('title', 'Penawaran & Harga Deal')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('orders.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Kesepakatan Penawaran (Harga Deal)</h2>
        <p class="text-sm text-gray-500 mt-1">Negosiasikan harga dengan pelanggan dan tetapkan harga final di sini.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
    
    <div class="mb-6 p-5 bg-slate-50 rounded-xl border border-slate-200 shadow-inner">
        <div class="flex justify-between items-center mb-4 border-b border-slate-200 pb-3">
            <div>
                <h4 class="font-extrabold text-slate-800 text-lg">JOB-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h4>
                <p class="text-sm text-slate-600 font-medium">Pelanggan: <span class="font-bold text-blue-600">{{ $order->customer->name ?? 'Pelanggan Dihapus' }}</span></p>
            </div>
            <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $order->status == 'ongoing' ? 'Sedang Dikerjakan' : 'Selesai' }}
            </span>
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

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            
            <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Kesepakatan Harga (Deal)
                </h3>
                
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">Harga Akhir / Deal (Rp)</label>
                    <input type="number" name="harga_penawaran" value="{{ $order->harga_penawaran }}" min="{{ $batas_bawah }}" required class="bg-white border-2 border-blue-400 text-blue-900 font-bold text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition shadow-sm">
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">Ubah angka ini jika terjadi kesepakatan negosiasi harga baru dengan pelanggan.</p>
                </div>
            </div>

            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Progres Pengerjaan
                </h3>
                
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">Status Proyek</label>
                    <select name="status" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition shadow-sm">
                        <option value="ongoing" {{ $order->status == 'ongoing' ? 'selected' : '' }}>Masih Dikerjakan (Ongoing)</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Sudah Selesai (Completed)</option>
                    </select>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">Ubah status menjadi 'Selesai' jika barang sudah diserahkan ke pelanggan.</p>
                </div>
            </div>
            
        </div>
        
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
            <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-8 py-3.5 text-center transition shadow-lg flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Simpan Penawaran & Status
            </button>
        </div>
    </form>
</div>
@endsection