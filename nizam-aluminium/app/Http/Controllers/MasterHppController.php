<?php

namespace App\Http\Controllers;

use App\Models\MasterHpp;
use Illuminate\Http\Request;

class MasterHppController extends Controller
{
    // 1. Menampilkan semua data Master HPP (SUDAH DIUBAH UNTUK PENCARIAN & PAGINATION)
    public function index(Request $request)
    {
        $query = MasterHpp::query();

        // Logika Filter Pencarian
        if ($request->filled('search')) {
            $query->where('nama_item', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_item', 'like', '%' . $request->search . '%');
        }

        // Mengambil data dengan pagination 10 baris per halaman
        $items = $query->orderBy('kategori')
                       ->orderBy('nama_item')
                       ->paginate(10)
                       ->withQueryString(); // Agar pencarian tidak hilang saat pindah halaman

        return view('master_hpp.index', compact('items'));
    }

    // 2. Menampilkan form tambah item baru
    public function create()
    {
        return view('master_hpp.create');
    }

    // 3. Menyimpan data item baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kode_item' => 'required|unique:master_hpps,kode_item',
            'nama_item' => 'required|string|max:255',
            'kategori' => 'required|in:Bahan Baku,Aksesoris,Upah Tenaga',
            'satuan' => 'required|string|max:50',
            'harga_dasar' => 'required|numeric|min:0',
        ]);

        MasterHpp::create($request->all());

        return redirect()->route('master-hpp.index')
                         ->with('success', 'Data Master HPP berhasil ditambahkan!');
    }

    // 4. Menampilkan form edit item
    public function edit(MasterHpp $masterHpp)
    {
        return view('master_hpp.edit', compact('masterHpp'));
    }

    // 5. Menyimpan perubahan data item
    public function update(Request $request, MasterHpp $masterHpp)
    {
        $request->validate([
            // Pengecualian unique ID agar tidak error saat update data sendiri
            'kode_item' => 'required|unique:master_hpps,kode_item,' . $masterHpp->id,
            'nama_item' => 'required|string|max:255',
            'kategori' => 'required|in:Bahan Baku,Aksesoris,Upah Tenaga',
            'satuan' => 'required|string|max:50',
            'harga_dasar' => 'required|numeric|min:0',
        ]);

        $masterHpp->update($request->all());

        return redirect()->route('master-hpp.index')
                         ->with('success', 'Data Master HPP berhasil diperbarui!');
    }

    // 6. Menghapus item dari Master HPP
    public function destroy(MasterHpp $masterHpp)
    {
        // Proteksi: Jika item sudah pernah dipakai di pesanan, sebaiknya jangan dihapus
        if ($masterHpp->orderDetails()->exists()) {
            return redirect()->route('master-hpp.index')
                             ->with('error', 'Item ini tidak bisa dihapus karena sedang digunakan dalam histori pesanan pelanggan.');
        }

        $masterHpp->delete();

        return redirect()->route('master-hpp.index')
                         ->with('success', 'Data Master HPP berhasil dihapus!');
    }
}