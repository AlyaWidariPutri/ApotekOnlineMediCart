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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat', 100);
            $table->foreignId('idjenis')->constrained('jenis_obat')->onDelete('cascade'); // Foreign Key ke tabel jenis_obats
            $table->integer('harga_jual'); // int(11)
            $table->text('deskripsi_obat'); // text
            $table->string('foto1', 255)->nullable(); // varchar(255), bisa null
            $table->string('foto2', 255)->nullable();
            $table->string('foto3', 255)->nullable();
            $table->integer('stok'); // int(11)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
