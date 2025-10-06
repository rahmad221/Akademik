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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('jenis_nilai_id')->constrained('jenis_nilais')->onDelete('cascade');
            // $table->unsignedBigInteger('mapel_id')->nullable(); // jika kamu punya tabel mapel
            $table->decimal('nilai', 5, 2)->nullable(); // contoh: 85.50
            $table->string('keterangan')->nullable(); // contoh: "Remedial", "Tuntas"
            $table->date('tanggal_input')->nullable();
            $table->timestamps();

            // Index tambahan jika nanti dibutuhkan untuk performa
            $table->index(['siswa_id', 'jenis_nilai_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilais');
    }
};
