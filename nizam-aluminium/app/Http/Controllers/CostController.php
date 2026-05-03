<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Order;
use Illuminate\Http\Request;

class CostController extends Controller
{
    public function index(Request $request)
    {
        $query = Cost::with('order');

        // Pencarian berdasarkan nama proyek (menggunakan relasi whereHas)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('order', function($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal spesifik pengeluaran
        if ($request->filled('date')) {
            $query->whereDate('cost_date', $request->date);
        }

        $costs = $query->latest()->paginate(10)->withQueryString();
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
        return redirect()->route('costs.index')->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}