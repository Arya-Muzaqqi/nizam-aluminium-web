<x-guest-layout>
    <!-- Pesan Error Bawaan Laravel -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Bagian Header & Logo NA -->
    <div class="text-center mb-8 mt-4">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 mb-5 shadow-lg shadow-blue-200 transform transition hover:scale-105">
            <span class="text-2xl font-bold text-white">NA</span>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Nizam Aluminium</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">Sistem Manajemen Keuangan</p>
    </div>

    <!-- Form Login Utama -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@contoh.com" class="pl-10 appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="pl-10 appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-200">
                <label for="remember_me" class="ml-2 block text-sm text-gray-600"> Ingat saya </label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-600 hover:text-blue-500 transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Tombol Sign In -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:-translate-y-0.5">
                Masuk ke Sistem
            </button>
        </div>
    </form>
</x-guest-layout>