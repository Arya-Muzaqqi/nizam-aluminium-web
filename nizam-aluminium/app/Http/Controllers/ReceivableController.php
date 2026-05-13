<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceivableController extends Controller
{
    // Menampilkan daftar proyek yang SUDAH DEAL untuk ditagih piutangnya
    public function index(Request $request)
    {
        // Hanya ambil order yang harga penawarannya sudah disepakati (> 0)
        $query = Order::with('customer')->where('harga_penawaran', '>', 0);

        if ($request->filled('search')) {
            $query->where('project_name', 'like', "%{$request->search}%");
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        return view('receivables.index', compact('orders'));
    }

    // Menampilkan form pembayaran DP/Cicilan dan ubah status
    public function edit(Order $order)
    {
        // Hitung berapa uang yang sudah masuk
        $total_paid = Payment::where('order_id', $order->id)->sum('amount');
        
        // Sisa piutang pelanggan
        $sisa_tagihan = $order->total_price - $total_paid;
        
        // Ambil histori pembayaran untuk ditampilkan
        $payments = Payment::where('order_id', $order->id)->latest()->get();

        return view('receivables.edit', compact('order', 'total_paid', 'sisa_tagihan', 'payments'));
    }

    // Menyimpan pembayaran baru & update status pengerjaan
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:ongoing,completed',
            'new_payment' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $order) {
            // 1. Update status pesanan (misal barang sudah diserahkan = completed)
            $order->update(['status' => $request->status]);

            // 2. Jika ada input uang masuk, catat ke tabel payments
            if ($request->filled('new_payment') && $request->new_payment > 0) {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $request->new_payment,
                    'payment_date' => now(),
                    'payment_type' => 'Pembayaran (DP/Cicilan)',
                ]);
            }
        });

        return redirect()->back()->with('success', 'Status pengerjaan / Pembayaran berhasil diperbarui!');
    }
}