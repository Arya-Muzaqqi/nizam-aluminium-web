@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="mb-5">
    <h2 class="text-2xl font-extrabold text-gray-800">Manajemen Pelanggan</h2>
    <p class="text-sm text-gray-500 mt-1">Kelola data kontak dan alamat pelanggan setia bengkel Anda.</p>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-5" role="alert">
    <span class="block sm:inline font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- TOOLBAR -->
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
        <form action="{{ route('customers.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau no. WA..." class="pl-9 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap shadow-sm w-full sm:w-auto">Cari</button>
            @if(request('search'))
                <a href="{{ route('customers.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap text-center border border-red-100 w-full sm:w-auto">Reset</a>
            @endif
        </form>

        <div class="w-full md:w-auto">
            <a href="{{ route('customers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center justify-center w-full md:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pelanggan
            </a>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-[11px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100 tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Nama Pelanggan</th>
                    <th scope="col" class="px-6 py-4 font-bold">No. WhatsApp</th>
                    <th scope="col" class="px-6 py-4 font-bold">Alamat Lengkap</th>
                    <th scope="col" class="px-6 py-4 text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr class="bg-white border-b border-gray-50 hover:bg-blue-50/30 transition">
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $customer->name }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-green-50 text-green-700 px-2.5 py-1 rounded-md text-xs font-semibold border border-green-100">{{ $customer->phone }}</span>
                    </td>
                    <td class="px-6 py-4">{{ $customer->address }}</td>
                    <td class="px-6 py-4 text-center flex justify-center space-x-2">
                        <!-- TOMBOL EDIT -->
                        <a href="{{ route('customers.edit', $customer->id) }}" class="text-yellow-600 hover:text-white border border-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-xs px-3 py-1.5 transition">Edit</a>
                        
                        <!-- TOMBOL HAPUS -->
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini beserta seluruh data pesanannya?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-white border border-red-200 hover:border-red-500 hover:bg-red-500 font-medium rounded-lg text-xs px-3 py-1.5 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data pelanggan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-50 bg-white">
        {{ $customers->links() }}
    </div>
</div>
@endsection