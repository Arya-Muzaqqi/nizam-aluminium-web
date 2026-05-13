<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke pesanan yang mana?
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            // Menghubungkan ke item Master HPP yang mana?
            $table->foreignId('master_hpp_id')->constrained('master_hpps');
            
            $table->decimal('kuantitas', 10, 2); // Jumlah pemakaian
            $table->integer('harga_satuan_saat_pesan'); // Mengunci harga Master HPP saat itu
            $table->integer('subtotal_hpp'); // kuantitas * harga_satuan_saat_pesan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
