<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Jika buka web pertama kali, langsung arahkan ke Dashboard (nanti otomatis dicegat disuruh Login)
Route::get('/', function () {
    return redirect('/dashboard');
});

// 2. Ini rute Dashboard yang diamankan (Hanya yang sudah login yang bisa masuk)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Rute bawaan Breeze untuk ganti password/profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';