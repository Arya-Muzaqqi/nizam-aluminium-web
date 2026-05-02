<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 1. Fungsi Laporan Laba Rugi / Job Costing
    public function jobCosting()
    {
        // Ambil semua pesanan dengan relasi biaya (costs) dan pelanggan
        $orders = Order::with(['customer', 'costs'])->latest()->get();

        // Kita hitung total bahan baku, upah, dan laba untuk masing-masing pesanan
        foreach ($orders as $order) {
            $order->material_cost = $order->costs->where('category', 'material')->sum('amount');
            $order->labor_cost = $order->costs->where('category', 'labor')->sum('amount');
            $order->overhead_cost = $order->costs->where('category', 'overhead')->sum('amount');
            
            // HPP (Harga Pokok Produksi)
            $order->total_cost = $order->material_cost + $order->labor_cost + $order->overhead_cost;
            
            // Laba Bersih = Harga Jual (Total Price) - HPP
            $order->profit = $order->total_price - $order->total_cost;
        }

        return view('reports.job-costing', compact('orders'));
    }

    // 2. Fungsi Laporan Daftar Piutang
    public function receivables()
    {
        // Ambil semua pesanan dengan relasi pembayaran dan pelanggan
        $orders = Order::with(['customer', 'payments'])->latest()->get();

        $receivables = collect(); // Membuat wadah kosong untuk menampung data yang belum lunas

        foreach ($orders as $order) {
            $total_paid = $order->payments->sum('amount'); // Hitung total DP/Cicilan yang sudah masuk
            $sisa_piutang = $order->total_price - $total_paid; // Hitung sisa

            // Jika sisa piutang lebih dari 0, berarti belum lunas, masukkan ke wadah
            if ($sisa_piutang > 0) {
                $order->total_paid = $total_paid;
                $order->sisa_piutang = $sisa_piutang;
                $receivables->push($order);
            }
        }

        return view('reports.receivables', compact('receivables'));
    }
}