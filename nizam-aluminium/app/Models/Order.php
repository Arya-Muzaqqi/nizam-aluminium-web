<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'project_name',
        'spesifikasi_teknis', // TAMBAHAN BARU
        'total_hpp',          // TAMBAHAN BARU
        'target_margin_persen', // TAMBAHAN BARU
        'harga_penawaran',    // TAMBAHAN BARU
        'total_price',        
        'order_date',
        'status'
    ];

    // Relasi ke tabel Customer (Milik siapa pesanan ini?)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi One-to-Many ke tabel Costs (Untuk Job Order Costing)
    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    // Relasi One-to-Many ke tabel Payments (Untuk pantau cicilan/DP)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}