<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Proyek Berjalan (Status bukan 'completed')
        $activeJobs = Order::where('status', '!=', 'completed')->count();

        // 2. Hitung Total DP (Uang Muka)
        $totalDP = Payment::where('payment_type', 'DP')->sum('amount');

        // 3. Hitung Sisa Piutang Keseluruhan
        $totalHargaKeseluruhan = Order::sum('total_price');
        $totalPembayaranMasuk = Payment::sum('amount');
        $totalPiutang = $totalHargaKeseluruhan - $totalPembayaranMasuk;

        // 4. Ambil 5 Pesanan Terbaru untuk ditampilkan di tabel
        $latestOrders = Order::with('customer')->latest()->take(5)->get();

        return view('dashboard', compact('activeJobs', 'totalDP', 'totalPiutang', 'latestOrders'));
    }
}