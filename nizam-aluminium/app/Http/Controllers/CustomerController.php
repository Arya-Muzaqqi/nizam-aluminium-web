<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Memulai query pelanggan
        $query = Customer::query();

        // Jika ada input pencarian dari view
        if ($request->filled('search')) {
            $search = $request->search;
            // Cari berdasarkan nama ATAU alamat
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        // withQueryString() agar saat pindah halaman paginasi, filter tidak hilang
        $customers = $query->latest()->paginate(10)->withQueryString();
        
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Pelanggan baru berhasil ditambahkan!');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil dihapus!');
    }
}