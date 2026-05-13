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
        Schema::table('orders', function (Blueprint $table) {
            $table->text('spesifikasi_teknis')->nullable()->after('project_name');
            $table->integer('total_hpp')->default(0)->after('spesifikasi_teknis');
            $table->decimal('target_margin_persen', 5, 2)->default(5.00)->after('total_hpp');
            $table->integer('harga_penawaran')->default(0)->after('target_margin_persen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
