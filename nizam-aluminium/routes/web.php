<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Rute Dasbor Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Menu Admin
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('costs', CostController::class);

    // Rute Menu Owner
    Route::get('/job-costing', [ReportController::class, 'jobCosting'])->name('reports.jobCosting');
    Route::get('/receivables', [ReportController::class, 'receivables'])->name('reports.receivables');
    Route::resource('users', UserController::class);

    // Rute Profil Bawaan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tambahkan baris ini untuk rute cetak nota spesifik per ID Proyek
    Route::get('/costs/nota/{id}', [App\Http\Controllers\CostController::class, 'exportNota'])->name('costs.nota');
});

require __DIR__.'/auth.php';