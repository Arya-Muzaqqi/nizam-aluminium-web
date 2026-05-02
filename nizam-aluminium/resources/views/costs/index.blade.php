@extends('layouts.app')

@section('title', 'Riwayat Pengeluaran Proyek')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-gray-700 text-lg font-semibold">Daftar Pengeluaran (HPP)</h3>
    <a href="{{ route('costs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Input Pengeluaran
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
                <th scope="col" class="px-6 py-4">Tanggal</th>
                <th scope="col" class="px-6 py-4">Nama Proyek</th>
                <th scope="col" class="px-6 py-4">Kategori</th>
                <th scope="col" class="px-6 py-4">Deskripsi Barang/Jasa</th>
                <th scope="col" class="px-6 py-4">Nominal</th>
                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($costs as $cost)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($cost->cost_date)->format('d M Y') }}</td>
                <td class="px-6 py-4 font-medium text-gray-900">
                    <span class="text-xs text-gray-400 block">JOB-{{ str_pad($cost->order->id, 4, '0', STR_PAD_LEFT) }}</span>
                    {{ $cost->order->project_name }}
                </td>
                <td class="px-6 py-4">
                    @if($cost->category == 'material')
                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Bahan Baku</span>
                    @elseif($cost->category == 'labor')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Upah Tukang</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Lainnya</span>
                    @endif
                </td>
                <td class="px-6 py-4">{{ $cost->description }}</td>
                <td class="px-6 py-4 font-bold text-red-600">Rp {{ number_format($cost->amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-center">
                    <form action="{{ route('costs.destroy', $cost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan/menghapus pengeluaran ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-md text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 border-dashed border-2 m-4">
                    Belum ada pengeluaran yang dicatat.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Area Pagination -->
    <div class="p-4 border-t border-gray-100">
        {{ $costs->links() }}
    </div>
</div>
@endsection