<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poli', function (Blueprint $table) {
            $table->id('id_poli');
            $table->string('kodepoli')->nullable();
            $table->string('namapoli')->nullable();
            $table->string('kodesubspesialis')->nullable();
            $table->string('namasubspesialis')->nullable();
            $table->string('status_poli')->default('Aktif')->comment('Aktif/Tidak');
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
        Schema::dropIfExists('poli');
    }
}
