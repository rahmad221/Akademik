<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('jenis_pembayaran_id');
            $table->string('periode')->nullable(); // contoh: Januari 2025, Februari 2025
            $table->decimal('jumlah', 12, 2)->default(0);
            $table->timestamps();
        
            $table->foreign('transaksi_id')->references('id')->on('transaksi_pembayaran')->onDelete('cascade');
            $table->foreign('jenis_pembayaran_id')->references('id')->on('jenis_pembayaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pembayaran');
    }
};
