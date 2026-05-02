<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CostController extends Controller
{
    public function index()
    {
        // Ubah get() menjadi paginate(10)
        $costs = Cost::with('order')->latest()->paginate(10);
        return view('costs.index', compact('costs'));
    }

    public function create()
    {
        $orders = Order::where('status', '!=', 'completed')->get();
        return view('costs.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'category' => 'required|in:material,labor,overhead',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'cost_date' => 'required|date',
        ]);

        Cost::create($request->all());

        return redirect()->route('costs.index')->with('success', 'Data pengeluaran berhasil dialokasikan ke proyek!');
    }

    public function destroy(Cost $cost)
    {
        $cost->delete();
        return redirect()->route('costs.index')->with('success', 'Data pengeluaran berhasil dibatalkan/dihapus!');
    }
}