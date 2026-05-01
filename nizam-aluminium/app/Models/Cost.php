<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $fillable = [
        'order_id',
        'category',
        'description',
        'amount',
        'cost_date',
    ];

    // Relasi ke tabel Order (Biaya ini untuk proyek yang mana?)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}