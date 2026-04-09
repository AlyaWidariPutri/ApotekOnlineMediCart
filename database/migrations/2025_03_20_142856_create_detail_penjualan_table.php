<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_penjualan')->unsigned();
            $table->bigInteger('id_obat')->unsigned();
            $table->integer('jumlah_beli');
            $table->double('harga_beli');
            $table->integer('subtotal'); // Sesuai dengan permintaan, pakai integer
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_penjualan')->references('id')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_obat')->references('id')->on('obat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
