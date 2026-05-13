<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterHppController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReceivableController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Rute Dasbor Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('master-hpp', MasterHppController::class);

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

    // Rute untuk Menu Penawaran
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    Route::get('/offers/{order}/edit', [OfferController::class, 'edit'])->name('offers.edit');
    Route::put('/offers/{order}', [OfferController::class, 'update'])->name('offers.update');

    // Tambahkan baris ini untuk rute cetak nota spesifik per ID Proyek
    Route::get('/costs/nota/{id}', [App\Http\Controllers\CostController::class, 'exportNota'])->name('costs.nota');

    // Rute untuk Menu Kelola Piutang & Pembayaran
    Route::get('/receivables', [ReceivableController::class, 'index'])->name('reports.receivables'); 
    Route::get('/receivables/{order}/edit', [ReceivableController::class, 'edit'])->name('receivables.edit');
    Route::put('/receivables/{order}', [ReceivableController::class, 'update'])->name('receivables.update');
});

require __DIR__.'/auth.php';