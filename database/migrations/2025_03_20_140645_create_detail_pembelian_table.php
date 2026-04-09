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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->bigIncrements('id');
            $table->bigInteger('id_obat')->unsigned();
            $table->integer('jumlah_beli');
            $table->double('harga_beli');
            $table->double('subtotal');
            $table->bigInteger('id_pembelian')->unsigned();
            $table->timestamps();
        
            // Foreign Key
            $table->foreign('id_obat')->references('id')->on('obat')->onDelete('cascade');
            $table->foreign('id_pembelian')->references('id')->on('pembelian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
