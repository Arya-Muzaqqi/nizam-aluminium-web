<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Jumlah Proyek Berjalan (Hanya yang statusnya 'ongoing')
        $activeJobs = Order::where('status', 'ongoing')->count();

        // 2. Total Uang Muka (DP) - HANYA UNTUK PROYEK ONGOING (Sesuai logika cerdas Anda!)
        $totalDP = Payment::where('payment_type', 'DP')
                    ->whereHas('order', function($query) {
                        $query->where('status', 'ongoing');
                    })->sum('amount');

        // 3. Sisa Piutang Keseluruhan
        $orders = Order::with('payments')->get();
        $totalPiutang = 0;
        
        foreach ($orders as $order) {
            $total_paid = $order->payments->sum('amount');
            $sisa = $order->total_price - $total_paid;
            
            // Jika ada sisa tagihan, tambahkan ke total piutang
            if ($sisa > 0) {
                $totalPiutang += $sisa;
            }
        }

        // 4. Ambil 5 Pesanan Terbaru untuk tabel di bawah
        $latestOrders = Order::with('customer')->latest('order_date')->take(5)->get();

        return view('dashboard', compact('activeJobs', 'totalDP', 'totalPiutang', 'latestOrders'));
    }
}