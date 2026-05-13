<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Fungsi Laporan Analisis Laba (Job Costing) khusus untuk Owner
    public function jobCosting(Request $request)
    {
        // Hanya ambil data pesanan yang harganya SUDAH DISEPAKATI (Harga Deal > 0)
        // Kita panggil relasi orderDetails dan masterHpp agar perhitungannya cepat
        $query = Order::with(['customer', 'orderDetails.masterHpp'])->where('harga_penawaran', '>', 0);

        // 1. Filter Pencarian (Nama Proyek, ID, atau Nama Customer)
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

        // 2. Filter Status Pengerjaan
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 3. Filter Bulan (Berdasarkan tanggal pesanan)
        if ($request->filled('month')) {
            $year = date('Y', strtotime($request->month));
            $month = date('m', strtotime($request->month));
            $query->whereYear('order_date', $year)
                  ->whereMonth('order_date', $month);
        }

        // ====================================================================
        // JIKA TOMBOL EXPORT EXCEL DIKLIK (MENGGUNAKAN TRIK NATIVE BLADE)
        // ====================================================================
        if ($request->has('export') && $request->export == 'excel') {
            $reports = $query->latest('order_date')->get(); 
            
            // Info filter untuk Kop Surat Excel
            $filterInfo = [
                'pencarian' => $request->search ? $request->search : 'Semua Data',
                'status' => $request->status == 'ongoing' ? 'Proses (Ongoing)' : ($request->status == 'completed' ? 'Selesai (Completed)' : 'Semua Status'),
                'periode_bulan' => $request->month ? Carbon::parse($request->month)->translatedFormat('F Y') : 'Semua Bulan',
                'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y')
            ];

            // Memaksa browser mengunduh tampilan Blade menjadi file MS Excel
            // Catatan: Pastikan isi file 'reports.exports.hpp' disesuaikan dengan variabel baru jika digunakan
            return response()->view('reports.exports.hpp', [
                'reports' => $reports,
                'filter' => $filterInfo
            ])
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Laporan_Analisis_Laba_Nizam_Aluminium.xls"');
        }

        // ====================================================================
        // JIKA TAMPILAN WEB BIASA
        // ====================================================================
        $reports = $query->latest('order_date')->paginate(10)->withQueryString();
        
        return view('reports.job-costing', compact('reports'));
    }
}