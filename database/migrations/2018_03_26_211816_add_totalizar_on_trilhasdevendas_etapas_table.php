<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalizarOnTrilhasdevendasEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trilhasdevendas_etapas', function (Blueprint $table) {
            $table->boolean('totalizar')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trilhasdevendas_etapas', function (Blueprint $table) {
            $table->dropColumn('totalizar');
        });
    }
}
