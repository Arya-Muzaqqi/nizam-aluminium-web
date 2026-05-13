@extends('layouts.app')

@section('title', 'Data Master HPP')

@section('content')
<div class="mb-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">Master HPP (Harga Dasar)</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola standar harga bahan baku dan upah operasional.</p>
    </div>
    
    <a href="{{ route('master-hpp.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Item Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
        <form action="{{ route('master-hpp.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Bahan / Kode..." class="pl-9 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition w-full sm:w-auto shadow-sm">Cari Data</button>
            @if(request('search'))
                <a href="{{ route('master-hpp.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2.5 rounded-lg text-sm font-semibold transition border border-red-100 w-full sm:w-auto text-center">Reset</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 min-w-max">
            <thead class="text-[11px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100 tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-bold text-center">Kode</th>
                    <th class="px-6 py-4 font-bold">Nama Item</th>
                    <th class="px-6 py-4 font-bold text-center">Kategori</th>
                    <th class="px-6 py-4 font-bold text-center">Satuan</th>
                    <th class="px-6 py-4 font-bold text-right">Harga Dasar</th>
                    <th class="px-6 py-4 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4 text-center font-mono text-xs text-blue-600 font-bold">{{ $item->kode_item }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $item->nama_item }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($item->kategori == 'Bahan Baku')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">Bahan Baku</span>
                        @elseif($item->kategori == 'Aksesoris')
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">Aksesoris</span>
                        @else
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">Upah Tenaga</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center font-medium">{{ $item->satuan }}</td>
                    <td class="px-6 py-4 text-right font-black text-gray-900">Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('master-hpp.edit', $item->id) }}" class="p-2 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 rounded-lg transition border border-yellow-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('master-hpp.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition border border-red-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Data tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $items->links() }}
    </div>
</div>
@endsection