<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntreanTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrean_task', function (Blueprint $table) {
            $table->id('id_antrean_task');
            $table->unsignedBigInteger('id_antrean');
            $table->unsignedBigInteger('id_task');
            $table->string('kodebooking')->nullable();
            $table->string('taskid')->nullable();
            $table->string('waktu')->nullable();
            $table->text('json_request')->nullable();
            $table->text('json_response')->nullable();
            $table->string('status_bpjs')->default('Belum')->comment('Belum/Sudah push ke server BPJS');
            $table->string('status_antrean_task')->default('Aktif')->comment('Aktif/Tidak');
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
        Schema::dropIfExists('antrean_task');
    }
}
