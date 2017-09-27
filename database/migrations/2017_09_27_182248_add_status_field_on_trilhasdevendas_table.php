<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusFieldOnTrilhasdevendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trilhasdevendas', function (Blueprint $table) {
            $table->boolean('ativo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trilhasdevendas', function (Blueprint $table) {
            $table->dropColumn('ativo');
        });
    }
}
