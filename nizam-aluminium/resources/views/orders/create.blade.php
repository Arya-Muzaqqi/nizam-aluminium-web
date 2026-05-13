@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('orders.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Pencatatan Pesanan</h2>
        <p class="text-sm text-gray-500 mt-1">Pilih pelanggan dan centang bahan baku. (Harga Deal ditentukan setelah ini).</p>
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

<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Informasi Proyek</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan <span class="text-red-500">*</span></label>
                    <select name="customer_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Proyek <span class="text-red-500">*</span></label>
                    <input type="text" name="project_name" value="{{ old('project_name') }}" placeholder="Contoh: Pemasangan Etalase Toko" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pesanan <span class="text-red-500">*</span></label>
                    <input type="date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Spesifikasi Teknis <span class="text-red-500">*</span></label>
                    <textarea name="spesifikasi_teknis" rows="3" placeholder="Tuliskan spesifikasi bentuk, ukuran, dan warna..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>{{ old('spesifikasi_teknis') }}</textarea>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-3">
                    <span class="block text-sm font-medium text-gray-600 mb-1">Estimasi Modal (HPP):</span>
                    <span class="font-black text-blue-800 text-xl">Rp <span id="label-total-hpp">0</span></span>
                </div>
                <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                    <span class="block text-xs font-bold text-red-500 uppercase tracking-wide mb-1">Batas Bawah Penawaran (+5%):</span>
                    <span class="font-black text-red-600 text-lg">Rp <span id="label-batas-bawah">0</span></span>
                </div>
            </div>
            
            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-lg shadow-lg transition-all flex justify-center items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                Lanjut ke Penawaran (Deal)
            </button>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-1">Rincian Komponen (Job Order Costing)</h3>
                <p class="text-xs text-gray-500 mb-4 border-b pb-2">Centang bahan yang digunakan dan isi jumlah kuantitasnya.</p>
                
                <div class="space-y-6">
                    <div>
                        <h4 class="font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg mb-3 inline-block text-sm">Bahan Baku (Aluminium & Kaca)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($bahanBaku as $item) @include('orders.partials.item_checkbox', ['item' => $item]) @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-purple-600 bg-purple-50 px-3 py-1.5 rounded-lg mb-3 inline-block text-sm">Aksesoris & Perlengkapan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($aksesoris as $item) @include('orders.partials.item_checkbox', ['item' => $item]) @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-orange-600 bg-orange-50 px-3 py-1.5 rounded-lg mb-3 inline-block text-sm">Upah Tenaga Kerja</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($upah as $item) @include('orders.partials.item_checkbox', ['item' => $item]) @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const qtyInputs = document.querySelectorAll('.item-qty');
        const labelHpp = document.getElementById('label-total-hpp');
        const labelBatas = document.getElementById('label-batas-bawah');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        function calculateHPP() {
            let totalHpp = 0;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    const qtyInput = document.querySelector(`input[name="items[${checkbox.dataset.id}][qty]"]`);
                    const price = parseFloat(checkbox.dataset.price);
                    const qty = parseFloat(qtyInput.value) || 0;
                    totalHpp += (price * qty);
                }
            });

            const batasBawah = totalHpp + (totalHpp * 0.05);

            labelHpp.innerText = formatRupiah(totalHpp);
            labelBatas.innerText = formatRupiah(batasBawah);
        }

        checkboxes.forEach(cb => cb.addEventListener('change', calculateHPP));
        qtyInputs.forEach(input => input.addEventListener('input', calculateHPP));
    });
</script>
@endsection