<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalPraktek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_praktek', function (Blueprint $table) {
            $table->id('id_jadwal_praktek');
            $table->unsignedBigInteger('id_poli')->nullable();
            $table->string('kodepoli')->nullable();
            $table->string('namapoli')->nullable();
            $table->string('kodesubspesialis')->nullable();
            $table->string('namasubspesialis')->nullable();
            $table->string('kodedokter')->nullable();
            $table->string('namadokter')->nullable();
            $table->integer('hari')->nullable();
            $table->integer('libur')->nullable();
            $table->string('namahari')->nullable();
            $table->string('jadwal')->nullable();
            $table->string('buka')->nullable();
            $table->string('tutup')->nullable();
            $table->integer('kapasitaspasien')->nullable();
            $table->integer('pasien_jkn')->default(0);
            $table->integer('pasien_umum')->default(0);
            $table->string('status_jadwal_praktek')->default('Aktif')->comment('Aktif/Tidak, Tidak=Hapus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_praktek');
    }
}
