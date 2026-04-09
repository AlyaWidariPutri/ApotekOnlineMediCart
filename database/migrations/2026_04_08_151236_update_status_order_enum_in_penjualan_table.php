<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cara 1: Menggunakan DB statement untuk MySQL
        DB::statement("ALTER TABLE penjualan 
            MODIFY COLUMN status_order ENUM(
                'Menunggu Konfirmasi', 
                'Diproses', 
                'Menunggu Kurir', 
                'Sedang Dikirim',
                'Selesai', 
                'Dibatalkan Pembeli', 
                'Dibatalkan Penjual', 
                'Bermasalah'
            ) DEFAULT 'Menunggu Konfirmasi'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE penjualan 
            MODIFY COLUMN status_order ENUM(
                'Menunggu Konfirmasi', 
                'Diproses', 
                'Menunggu Kurir', 
                'Selesai', 
                'Dibatalkan Pembeli', 
                'Dibatalkan Penjual', 
                'Bermasalah'
            ) DEFAULT 'Menunggu Konfirmasi'");
    }
};