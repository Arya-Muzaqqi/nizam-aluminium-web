@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<!-- Header Judul -->
<div class="mb-5">
    <h2 class="text-2xl font-extrabold text-gray-800">Data Pelanggan</h2>
    <p class="text-sm text-gray-500 mt-1">Manajemen informasi dan kontak pelanggan bengkel.</p>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-5" role="alert">
    <span class="block sm:inline font-medium">{{ session('success') }}</span>
</div>
@endif

<!-- Kotak Utama (Toolbar & Tabel) -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <!-- TOOLBAR: Kiri (Search) & Kanan (Tambah) -->
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
        
        <!-- Kiri: Form Pencarian -->
        <form action="{{ route('customers.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau alamat..." class="pl-9 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap w-full sm:w-auto shadow-sm">Cari</button>
            @if(request('search'))
                <a href="{{ route('customers.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap w-full sm:w-auto text-center border border-red-100">Reset</a>
            @endif
        </form>

        <!-- Kanan: Tombol Tambah Data -->
        <div class="w-full md:w-auto flex-shrink-0">
            <a href="{{ route('customers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center justify-center w-full md:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pelanggan
            </a>
        </div>
    </div>

    <!-- Tabel Data -->
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-[11px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100 tracking-wider">
            <tr>
                <th scope="col" class="px-6 py-4 font-bold">Nama</th>
                <th scope="col" class="px-6 py-4 font-bold">No. WhatsApp</th>
                <th scope="col" class="px-6 py-4 font-bold">Alamat</th>
                <th scope="col" class="px-6 py-4 text-center font-bold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                <td class="px-6 py-4 font-bold text-gray-800">{{ $customer->name }}</td>
                <td class="px-6 py-4">{{ $customer->phone }}</td>
                <td class="px-6 py-4">{{ $customer->address ?? '-' }}</td>
                <td class="px-6 py-4 text-center flex justify-center space-x-2">
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-white border border-red-200 hover:border-red-500 hover:bg-red-500 font-medium rounded-lg text-xs px-3 py-1.5 transition">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-400">Tidak ada data pelanggan yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="p-4 border-t border-gray-50 bg-white">
        {{ $customers->links() }}
    </div>
</div>
@endsection