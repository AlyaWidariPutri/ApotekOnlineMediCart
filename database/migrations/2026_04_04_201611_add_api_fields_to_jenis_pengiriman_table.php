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
        Schema::table('jenis_pengiriman', function (Blueprint $table) {
            $table->string('kode_kurir')->nullable()->after('nama_ekspedisi'); // jne, jnt, sicepat
            $table->string('layanan')->nullable()->after('kode_kurir'); // REG, OKE, YES
            $table->boolean('is_active')->default(true)->after('layanan');
        });
    }

    public function down()
    {
        Schema::table('jenis_pengiriman', function (Blueprint $table) {
            $table->dropColumn(['kode_kurir', 'layanan', 'is_active']);
        });
    }
};
