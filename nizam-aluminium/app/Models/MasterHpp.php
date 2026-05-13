<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHpp extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara spesifik (opsional tapi disarankan)
    protected $table = 'master_hpps';

    // Kolom apa saja yang boleh diisi (dinput) oleh Owner
    protected $fillable = [
        'kode_item', 
        'nama_item', 
        'kategori', 
        'satuan', 
        'harga_dasar'
    ];

    // Relasi: Satu bahan baku di Master HPP bisa dipakai di banyak rincian pesanan
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}