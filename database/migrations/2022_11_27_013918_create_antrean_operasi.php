<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntreanOperasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrean_operasi', function (Blueprint $table) {
            $table->id('id_antrean_operasi');
            $table->unsignedBigInteger('id_poli')->nullable();
            $table->string('kodebooking')->nullable()->index();
            $table->date('tanggaloperasi')->nullable();
            $table->string('jenistindakan')->nullable();
            $table->string('kodepoli')->nullable();
            $table->string('namapoli')->nullable();
            $table->integer('terlaksana')->default(0);
            $table->string('nopeserta')->nullable();
            $table->float('lastupdate', 14, 0)->nullable();
            $table->string('status_antrean_operasi')->default('Aktif')->comment('Aktif/Tidak, Tidak=Hapus');
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
        Schema::dropIfExists('antrean_operasi');
    }
}
