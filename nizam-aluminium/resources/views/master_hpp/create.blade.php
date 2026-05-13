@extends('layouts.app')

@section('title', 'Tambah Item Master HPP')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('master-hpp.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Tambah Item Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Masukkan data bahan baku, aksesoris, atau upah tenaga.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <form action="{{ route('master-hpp.store') }}" method="POST" class="p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Item <span class="text-red-500">*</span></label>
                <input type="text" name="kode_item" value="{{ old('kode_item') }}" placeholder="Contoh: ALM-001" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('kode_item') border-red-500 @enderror" required>
                @error('kode_item') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="nama_item" value="{{ old('nama_item') }}" placeholder="Contoh: Aluminium Alexindo 4 Inch" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('nama_item') border-red-500 @enderror" required>
                @error('nama_item') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('kategori') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Bahan Baku" {{ old('kategori') == 'Bahan Baku' ? 'selected' : '' }}>Bahan Baku</option>
                    <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                    <option value="Upah Tenaga" {{ old('kategori') == 'Upah Tenaga' ? 'selected' : '' }}>Upah Tenaga</option>
                </select>
                @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Satuan Ukur <span class="text-red-500">*</span></label>
                <input type="text" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: Batang, Meter, Pcs, Hari" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('satuan') border-red-500 @enderror" required>
                @error('satuan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar / Modal (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                    </div>
                    <input type="number" name="harga_dasar" value="{{ old('harga_dasar') }}" min="0" placeholder="Contoh: 150000" class="pl-10 w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('harga_dasar') border-red-500 @enderror" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">Masukkan angka saja tanpa titik/koma. Harga ini akan menjadi acuan saat membuat penawaran pesanan.</p>
                @error('harga_dasar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">
            <button type="reset" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition">Reset</button>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Item
            </button>
        </div>
    </form>
</div>
@endsection