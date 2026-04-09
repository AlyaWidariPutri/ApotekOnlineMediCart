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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_metode_bayar')->constrained('metode_bayar')->onDelete('cascade');
            $table->date('tgl_penjualan');
            $table->string('url_resep', 255)->nullable();
            $table->double('ongkos_kirim');
            $table->double('biaya_app');
            $table->double('total_bayar');
            $table->enum('status_order', [
                'Menunggu Konfirmasi', 'Diproses', 'Menunggu Kurir', 
                'Dibatalkan Pembeli', 'Dibatalkan Penjual', 'Bermasalah', 'Selesai'
            ]);
            $table->string('keterangan_status', 255)->nullable();
            $table->foreignId('id_jenis_kirim')->constrained('jenis_pengiriman')->onDelete('cascade');
            $table->foreignId('id_pelanggan')->constrained('pelanggan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
