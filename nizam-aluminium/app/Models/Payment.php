<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'payment_date',
        'payment_type',
    ];

    // Relasi ke tabel Order (Pembayaran ini untuk melunasi proyek yang mana?)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}