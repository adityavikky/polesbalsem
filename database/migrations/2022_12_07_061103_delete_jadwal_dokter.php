<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteJadwalDokter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dokter_jadwal');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('dokter_jadwal', function (Blueprint $table) {
            $table->id('id_dokter_jadwal');
            $table->unsignedBigInteger('id_poli');
            $table->unsignedBigInteger('id_dokter');
            $table->integer('hari')->nullable();
            $table->integer('libur')->nullable();
            $table->string('namahari')->nullable();
            $table->integer('kodedokter')->nullable();
            $table->string('namadokter')->nullable();
            $table->string('kodepoli')->nullable();
            $table->string('namapoli')->nullable();
            $table->string('kodesubspesialis')->nullable();
            $table->string('namasubspesialis')->nullable();
            $table->string('jadwal')->nullable();
            $table->integer('kapasitaspasien')->default(0);
            $table->string('status_dokter_jadwal')->default('Aktif')->comment('Aktif/Tidak');
            $table->timestamps();
        });
    }
}
