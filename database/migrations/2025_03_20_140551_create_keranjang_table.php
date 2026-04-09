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
        Schema::create('keranjang', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->bigIncrements('id'); // Primary Key
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_obat');
            $table->double('jumlah_order');
            $table->double('harga');
            $table->double('subtotal');
            $table->timestamps(); // created_at & updated_at

            // Foreign Keys
            $table->foreign('id_pelanggan')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('id_obat')->references('id')->on('obat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
