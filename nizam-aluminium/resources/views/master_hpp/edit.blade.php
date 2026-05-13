@extends('layouts.app')

@section('title', 'Edit Item Master HPP')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('master-hpp.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Edit Item Master HPP</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui data standar harga atau informasi item.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <form action="{{ route('master-hpp.update', $masterHpp->id) }}" method="POST" class="p-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Item <span class="text-red-500">*</span></label>
                <input type="text" name="kode_item" value="{{ old('kode_item', $masterHpp->kode_item) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('kode_item') border-red-500 @enderror" required>
                @error('kode_item') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="nama_item" value="{{ old('nama_item', $masterHpp->nama_item) }}" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('nama_item') border-red-500 @enderror" required>
                @error('nama_item') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('kategori') border-red-500 @enderror" required>
                    <option value="Bahan Baku" {{ old('kategori', $masterHpp->kategori) == 'Bahan Baku' ? 'selected' : '' }}>Bahan Baku</option>
                    <option value="Aksesoris" {{ old('kategori', $masterHpp->kategori) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                    <option value="Upah Tenaga" {{ old('kategori', $masterHpp->kategori) == 'Upah Tenaga' ? 'selected' : '' }}>Upah Tenaga</option>
                </select>
                @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Satuan Ukur <span class="text-red-500">*</span></label>
                <input type="text" name="satuan" value="{{ old('satuan', $masterHpp->satuan) }}" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('satuan') border-red-500 @enderror" required>
                @error('satuan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar / Modal (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                    </div>
                    <input type="number" name="harga_dasar" value="{{ old('harga_dasar', $masterHpp->harga_dasar) }}" min="0" class="pl-10 w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 @error('harga_dasar') border-red-500 @enderror" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">Perubahan harga di sini hanya akan berpengaruh pada pesanan baru di masa mendatang.</p>
                @error('harga_dasar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">
            <a href="{{ route('master-hpp.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition text-center">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Perbarui Item
            </button>
        </div>
    </form>
</div>
@endsection