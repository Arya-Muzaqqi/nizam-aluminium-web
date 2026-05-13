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
        Schema::create('master_hpps', function (Blueprint $table) {
            $table->id();
            $table->string('kode_item')->unique(); // Contoh: ALM-001
            $table->string('nama_item'); // Contoh: Aluminium Alexindo 4 Inch
            $table->enum('kategori', ['Bahan Baku', 'Aksesoris', 'Upah Tenaga']);
            $table->string('satuan'); // Contoh: Batang, Meter, Pcs
            $table->integer('harga_dasar'); // Modal murni dari Owner
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_hpps');
    }
};
