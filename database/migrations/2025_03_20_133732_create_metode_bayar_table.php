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
        Schema::create('metode_bayar', function (Blueprint $table) {
            $table->id();
            // $table->bigIncrements('id'); // Primary key (bigint unsigned auto-increment)
            $table->string('metode_pembayaran', 30); // Nama metode pembayaran
            $table->string('tempat_bayar', 50); // Tempat pembayaran (bank, e-wallet, dll)
            $table->string('no_rekening', 25)->nullable(); // No rekening (boleh kosong)
            $table->string('url_logo', 255)->nullable(); // URL logo metode pembayaran (boleh kosong)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_bayar');
    }
};
