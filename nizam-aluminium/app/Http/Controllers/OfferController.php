<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    // Menampilkan halaman Daftar Penawaran
    public function index(Request $request)
    {
        $query = Order::with('customer');

        if ($request->filled('search')) {
            $query->where('project_name', 'like', "%{$request->search}%");
        }

        // Tampilkan semua pesanan, diurutkan dari yang terbaru
        $offers = $query->latest()->paginate(10)->withQueryString();
        
        return view('offers.index', compact('offers'));
    }

    // Menampilkan Form Input Harga Deal
    public function edit(Order $order)
    {
        return view('offers.edit', compact('order'));
    }

    // Menyimpan Harga Deal ke Database
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'harga_penawaran' => 'required|numeric|min:0',
        ]);

        // Hitung batas bawah (HPP + 5%)
        $margin_minimal = $order->total_hpp * 0.05;
        $harga_batas_bawah = $order->total_hpp + $margin_minimal;

        if ($request->harga_penawaran < $harga_batas_bawah) {
            return back()->with('error', 'Gagal! Harga Deal tidak boleh di bawah Batas Bawah (+5%).');
        }

        // Update harga_penawaran dan total_price (harga final)
        $order->update([
            'harga_penawaran' => $request->harga_penawaran,
            'total_price' => $request->harga_penawaran,
        ]);

        return redirect()->route('offers.index')->with('success', 'Harga Penawaran (Deal) berhasil disepakati!');
    }
}