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
        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            $table->enum('tipe_pembayaran', ['bulanan', 'sekali'])->default('sekali')->after('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            $table->dropColumn('tipe_pembayaran');
        });
    }
};
