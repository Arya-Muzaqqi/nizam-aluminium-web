@extends('layouts.app')

@section('title', 'Dasbor Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Kartu 1 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyek Berjalan</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">2</h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-xl">💼</div>
    </div>

    <!-- Kartu 2 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Uang Muka (DP)</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 19.000.000</h3>
        </div>
        <div class="w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-xl">💵</div>
    </div>

    <!-- Kartu 3 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sisa Piutang</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 22.500.000</h3>
        </div>
        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center text-xl">💳</div>
    </div>
</div>

<!-- Area Tabel -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-800">Pesanan Terbaru</h3>
    </div>
    <div class="p-8 text-center text-gray-400 border-2 border-dashed border-gray-200 m-4 rounded-lg">
        Tabel data pesanan akan dimunculkan di sini nanti...
    </div>
</div>
@endsection