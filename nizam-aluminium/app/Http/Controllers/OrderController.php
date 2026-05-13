<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\MasterHpp;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // MENAMPILKAN DAFTAR PESANAN & PENAWARAN
    public function index(Request $request)
    {
        $query = Order::with('customer');

        if ($request->filled('search')) {
            $query->where('project_name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        return view('orders.index', compact('orders'));
    }

    // TAHAP 1: MENGIRIM DATA MASTER HPP KE FORM PESANAN BARU
    public function create()
    {
        $customers = Customer::all();
        
        // Membagi Master HPP berdasarkan kategori agar mudah ditampilkan di form
        $bahanBaku = MasterHpp::where('kategori', 'Bahan Baku')->get();
        $aksesoris = MasterHpp::where('kategori', 'Aksesoris')->get();
        $upah = MasterHpp::where('kategori', 'Upah Tenaga')->get();

        return view('orders.create', compact('customers', 'bahanBaku', 'aksesoris', 'upah'));
    }

    // TAHAP 1: MENYIMPAN DATA PROYEK & MENGHITUNG HPP (BELUM ADA HARGA DEAL)
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'project_name' => 'required|string|max:200',
            'spesifikasi_teknis' => 'required|string',
            'order_date' => 'required|date',
            'items' => 'required|array', // Admin wajib memilih minimal 1 bahan
        ]);

        DB::transaction(function () use ($request) {
            // 1. Hitung Total HPP dari item yang dicentang admin
            $total_hpp = 0;
            $orderDetails = [];

            foreach ($request->items as $itemId => $data) {
                // Jika item dicentang (kuantitas lebih dari 0)
                if (isset($data['selected']) && $data['qty'] > 0) {
                    $masterItem = MasterHpp::find($itemId);
                    $subtotal = $masterItem->harga_dasar * $data['qty'];
                    $total_hpp += $subtotal;

                    // Siapkan data untuk dimasukkan ke tabel order_details
                    $orderDetails[] = [
                        'master_hpp_id' => $masterItem->id,
                        'kuantitas' => $data['qty'],
                        'harga_satuan_saat_pesan' => $masterItem->harga_dasar, // Mengunci harga dasar saat itu
                        'subtotal_hpp' => $subtotal,
                    ];
                }
            }

            // 2. Simpan data ke tabel orders (Harga Penawaran diatur 0 dulu)
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'project_name' => $request->project_name,
                'spesifikasi_teknis' => $request->spesifikasi_teknis,
                'total_hpp' => $total_hpp,
                'target_margin_persen' => 5.00,
                'harga_penawaran' => 0, // Di-set 0 sebagai tanda belum ada kesepakatan harga
                'total_price' => 0, 
                'order_date' => $request->order_date,
                'status' => 'ongoing',
            ]);

            // 3. Simpan rincian bahan ke tabel order_details
            foreach ($orderDetails as $detail) {
                $detail['order_id'] = $order->id;
                OrderDetail::create($detail);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Tahap 1 selesai! Rincian bahan dicatat. Silakan buat Harga Kesepakatan (Deal).');
    }

    // TAHAP 2: MENAMPILKAN FORM NEGOSIASI HARGA DEAL
    public function edit(Order $order)
    {
        // Hanya mengambil data ini untuk ditampilkan di bagian atas form
        $total_paid = Payment::where('order_id', $order->id)->sum('amount');
        $sisa_tagihan = $order->total_price - $total_paid;
        
        return view('orders.edit', compact('order', 'total_paid', 'sisa_tagihan'));
    }

    // TAHAP 2: MENYIMPAN HARGA DEAL FINAL & STATUS
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:ongoing,completed',
            'harga_penawaran' => 'required|numeric|min:0',
        ]);

        // Hitung ulang batas bawah untuk keamanan agar tidak rugi (HPP + 5%)
        $margin_minimal = $order->total_hpp * 0.05;
        $harga_batas_bawah = $order->total_hpp + $margin_minimal;

        if ($request->harga_penawaran < $harga_batas_bawah) {
            return back()->with('error', 'Gagal! Harga Deal tidak boleh di bawah Batas Bawah (+5%).');
        }

        // Update data harga deal dan status
        $order->update([
            'status' => $request->status,
            'harga_penawaran' => $request->harga_penawaran,
            'total_price' => $request->harga_penawaran, // Samakan total tagihan pelanggan dengan harga deal
        ]);

        return redirect()->route('orders.index')->with('success', 'Harga Deal dan Status proyek berhasil diperbarui!');
    }

    // MENGHAPUS PESANAN BERSAMA RINCIAN BAHANNYA
    public function destroy(Order $order)
    {
        // Fitur hapus otomatis (cascade) akan menghapus data di order_details berkat aturan di migration
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Data pesanan berhasil dihapus secara permanen!');
    }
}