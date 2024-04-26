<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrean extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrean', function (Blueprint $table) {
            $table->id('id_antrean');
            $table->unsignedBigInteger('id_poli')->nullable();
            $table->unsignedBigInteger('id_loket')->nullable();
            $table->unsignedBigInteger('id_dokter')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('kodebooking')->nullable()->index();
            $table->string('jenispasien')->nullable();
            $table->string('nomorkartu')->nullable();
            $table->string('nik')->nullable();
            $table->string('nohp')->nullable();
            $table->string('kodepoli')->nullable();
            $table->string('namapoli')->nullable();
            $table->integer('pasienbaru')->nullable();
            $table->string('norm')->nullable();
            $table->date('tanggalperiksa')->nullable();
            $table->string('kodedokter')->nullable();
            $table->string('namadokter')->nullable();
            $table->string('jampraktek')->nullable();
            $table->string('jeniskunjungan')->nullable();
            $table->string('nomorreferensi')->nullable();
            $table->string('nomorantrean')->nullable();
            $table->string('angkaantrean')->nullable();
            $table->string('estimasidilayani')->nullable();
            $table->string('sisakuotajkn')->nullable();
            $table->string('kuotajkn')->nullable();
            $table->string('sisakuotanonjkn')->nullable();
            $table->string('kuotanonjkn')->nullable();
            $table->string('keterangan')->nullable();
            $table->text('json_request')->nullable();
            $table->text('json_response')->nullable();
            $table->string('status_bpjs')->default('Belum')->comment('Belum/Sudah push ke server BPJS');
            $table->string('status_antrean')->default('Aktif')->comment('Aktif/Tidak, Tidak=Hapus');
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
        Schema::dropIfExists('antrean');
    }
}
