<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'master_hpp_id',
        'kuantitas',
        'harga_satuan_saat_pesan',
        'subtotal_hpp'
    ];

    // Relasi: Rincian ini milik 1 Pesanan (Order)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: Rincian ini mengambil data dari 1 Master HPP
    public function masterHpp()
    {
        return $this->belongsTo(MasterHpp::class);
    }
}