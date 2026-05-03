<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    // 1. Fungsi Laporan Laba Rugi / Job Costing
    public function jobCosting(Request $request)
    {
        // Ambil data beserta relasinya
        $query = Order::with(['customer', 'costs']);

        // 1. Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($qC) use ($search) {
                      $qC->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filter Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 3. Filter Bulan (Berdasarkan tanggal pesanan/proyek)
        if ($request->filled('month')) {
            $year = date('Y', strtotime($request->month));
            $month = date('m', strtotime($request->month));
            $query->whereYear('order_date', $year)
                  ->whereMonth('order_date', $month);
        }

        // JIKA TOMBOL EXPORT EXCEL DIKLIK (MENGGUNAKAN TRIK NATIVE)
        if ($request->has('export') && $request->export == 'excel') {
            $orders = $query->latest('order_date')->get(); 
            
            foreach ($orders as $order) {
                $order->material_cost = $order->costs->where('category', 'material')->sum('amount');
                $order->labor_cost = $order->costs->where('category', 'labor')->sum('amount');
                $order->overhead_cost = $order->costs->where('category', 'overhead')->sum('amount');
                $order->total_cost = $order->material_cost + $order->labor_cost + $order->overhead_cost;
                $order->profit = $order->total_price - $order->total_cost;
            }

            // Info filter untuk Kop Surat Excel
            $filterInfo = [
                'pencarian' => $request->search ? $request->search : 'Semua Data',
                'status' => $request->status == 'ongoing' ? 'Proses (Ongoing)' : ($request->status == 'completed' ? 'Selesai (Completed)' : 'Semua Status'),
                'periode_bulan' => $request->month ? Carbon::parse($request->month)->translatedFormat('F Y') : 'Semua Bulan',
                'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y')
            ];

            // Trik Ajaib: Memaksa browser mengunduh tampilan Blade menjadi file MS Excel
            return response()->view('reports.exports.hpp', [
                'orders' => $orders,
                'filter' => $filterInfo
            ])
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Laporan_HPP_Nizam_Aluminium.xls"');
        }

        // JIKA TAMPILAN WEB BIASA
        $orders = $query->latest('order_date')->paginate(10)->withQueryString();
        
        foreach ($orders as $order) {
            $order->material_cost = $order->costs->where('category', 'material')->sum('amount');
            $order->labor_cost = $order->costs->where('category', 'labor')->sum('amount');
            $order->overhead_cost = $order->costs->where('category', 'overhead')->sum('amount');
            $order->total_cost = $order->material_cost + $order->labor_cost + $order->overhead_cost;
            $order->profit = $order->total_price - $order->total_cost;
        }

        return view('reports.job-costing', compact('orders'));
    }

    // 2. Fungsi Laporan Daftar Piutang
    public function receivables(Request $request)
    {
        $query = Order::with(['customer', 'payments']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($qC) use ($search) {
                      $qC->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest('order_date')->get();
        $receivables = collect();

        foreach ($orders as $order) {
            $total_paid = $order->payments->sum('amount');
            $sisa_piutang = $order->total_price - $total_paid;

            if ($sisa_piutang > 0) {
                $order->total_paid = $total_paid;
                $order->sisa_piutang = $sisa_piutang;
                $receivables->push($order);
            }
        }

        return view('reports.receivables', compact('receivables'));
    }
}