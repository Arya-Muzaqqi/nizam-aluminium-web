@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-gray-700 text-lg font-semibold">Daftar Pelanggan</h3>
    <a href="{{ route('customers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Tambah Pelanggan
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th scope="col" class="px-6 py-4">Nama</th>
                <th scope="col" class="px-6 py-4">No. WhatsApp</th>
                <th scope="col" class="px-6 py-4">Alamat</th>
                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $customer->name }}</td>
                <td class="px-6 py-4">{{ $customer->phone }}</td>
                <td class="px-6 py-4">{{ $customer->address ?? '-' }}</td>
                <td class="px-6 py-4 text-center flex justify-center space-x-2">
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini? Semua pesanan miliknya juga akan terhapus!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-md">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-400 border-dashed border-2 m-4">
                    Belum ada data pelanggan terdaftar.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Area Pagination -->
    <div class="p-4 border-t border-gray-100">
        {{ $customers->links() }}
    </div>
</div>
@endsection