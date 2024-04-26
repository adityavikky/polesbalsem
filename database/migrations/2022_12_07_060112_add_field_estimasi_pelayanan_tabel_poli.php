<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldEstimasiPelayananTabelPoli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'poli',
            function (Blueprint $table) {
                $table->integer('estimasi_pelayanan')->default(0)->after('namasubspesialis');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'poli',
            function (Blueprint $table) {
                $table->dropColumn(['estimasi_pelayanan']);
            }
        );
    }
}
