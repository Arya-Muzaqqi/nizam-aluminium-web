@extends('layouts.app')

@section('title', 'Kelola Pengguna Sistem')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-gray-700 text-lg font-semibold">Daftar Pengguna Aktif</h3>
    <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Tambah Pengguna
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="block sm:inline">{{ session('error') }}</span>
</div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                <th scope="col" class="px-6 py-4">Alamat Email</th>
                <th scope="col" class="px-6 py-4 text-center">Peran (Role)</th>
                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 {{ $user->role == 'owner' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }} text-xs rounded-full">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center flex justify-center space-x-2">
                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-2 rounded-md text-xs font-medium">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-2 rounded-md text-xs font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Area Pagination -->
    <div class="p-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection