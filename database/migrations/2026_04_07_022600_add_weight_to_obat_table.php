<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            if (!Schema::hasColumn('obat', 'berat')) {
                $table->integer('berat')->default(100)->after('harga_jual')->comment('Berat dalam gram');
            }
        });
    }

    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn('berat');
        });
    }
};