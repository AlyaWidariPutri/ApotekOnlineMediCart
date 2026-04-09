<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            // Cek apakah kolom alamat2 belum ada, baru tambahkan
            if (!Schema::hasColumn('pelanggan', 'alamat2')) {
                $table->text('alamat2')->nullable()->after('kodepos2');
            }
            
            // Cek apakah kolom alamat3 belum ada, baru tambahkan
            if (!Schema::hasColumn('pelanggan', 'alamat3')) {
                $table->text('alamat3')->nullable()->after('kodepos3');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn(['alamat2', 'alamat3']);
        });
    }
};