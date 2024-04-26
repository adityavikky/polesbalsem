<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AntreanAddFieldCheckin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antrean', function (Blueprint $table) {
            $table->float('checkin', 14, 0)->nullable();
            $table->string('daftaronline')->default('Tidak')->comment('Ya/Tidak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'antrean',
            function (Blueprint $table) {
                $table->dropColumn(['checkin', 'daftaronline']);
            }
        );
    }
}
