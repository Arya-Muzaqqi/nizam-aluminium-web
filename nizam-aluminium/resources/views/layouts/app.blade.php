<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nizam Aluminium - @yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex h-screen overflow-hidden">

    <!-- BAGIAN KIRI: SIDEBAR -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <div class="w-8 h-8 bg-blue-500 rounded flex items-center justify-center text-white font-bold mr-3">NA</div>
            <div>
                <h1 class="text-sm font-bold text-gray-900">Nizam Aluminium</h1>
                <p class="text-xs text-gray-500">Workshop Financial</p>
            </div>
        </div>

<!-- Menu Navigasi Samping -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            
            <!-- MENU ADMIN (Hanya tampil jika yang login adalah Admin) -->
            @if(Auth::user()->role === 'admin')
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Panel Admin</p>
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Dasbor
            </a>
            <a href="{{ route('customers.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Data Pelanggan
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Pesanan & Pembayaran
            </a>
            <a href="{{ route('costs.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Input Pengeluaran
            </a>
            @endif

            <!-- MENU OWNER -->
            @if(Auth::check() && Auth::user()->role === 'owner')
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Panel Pemilik</p>
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Dasbor Keuangan
            </a>
            <a href="{{ route('reports.jobCosting') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Laporan HPP (Job Costing)
            </a>
            <a href="{{ route('reports.receivables') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Laporan Piutang
            </a>
            <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Kelola Pengguna
            </a>
            @endif

        </nav>

        <!-- Info User & Logout -->
        <div class="p-4 border-t border-gray-200">
            <p class="text-xs text-gray-500 mb-1">Logged in as:</p>
            <p class="text-sm text-gray-800 font-semibold truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500 mb-3 capitalize">{{ Auth::user()->role }}</p>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md text-red-600 hover:bg-red-50 transition">
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    <!-- BAGIAN KANAN: KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-8">
            <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
        </header>
        <div class="flex-1 overflow-y-auto p-8 bg-[#F4F7FB]">
            @yield('content')
        </div>
    </main>
</body>
</html>