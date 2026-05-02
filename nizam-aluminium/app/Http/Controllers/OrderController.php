<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Ubah get() menjadi paginate(10)
        $orders = Order::with('customer')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'project_name' => 'required|string|max:200',
            'total_price' => 'required|numeric|min:0',
            'dp_amount' => 'nullable|numeric|min:0',
            'order_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'project_name' => $request->project_name,
                'total_price' => $request->total_price,
                'order_date' => $request->order_date,
                'status' => 'ongoing',
            ]);

            if ($request->dp_amount > 0) {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $request->dp_amount,
                    'payment_date' => $request->order_date,
                    'payment_type' => 'DP',
                ]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan proyek dan Uang Muka berhasil dicatat!');
    }

    public function edit(Order $order)
    {
        $total_paid = Payment::where('order_id', $order->id)->sum('amount');
        $sisa_tagihan = $order->total_price - $total_paid;
        
        return view('orders.edit', compact('order', 'total_paid', 'sisa_tagihan'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:ongoing,completed',
            'new_payment' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $order) {
            $order->update([
                'status' => $request->status
            ]);

            if ($request->new_payment > 0) {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $request->new_payment,
                    'payment_date' => now(),
                    'payment_type' => 'Pelunasan / Cicilan',
                ]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Status proyek dan pembayaran berhasil diperbarui!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Data pesanan berhasil dihapus!');
    }
}