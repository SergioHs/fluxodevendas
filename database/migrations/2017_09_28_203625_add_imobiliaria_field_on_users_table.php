<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImobiliariaFieldOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
			$table->integer('imobiliaria_id')->unsigned()->nullable();
            $table->foreign('imobiliaria_id')->
              references('id')->on('imobiliarias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['imobiliaria_id']);
            $table->dropColumn('imobiliaria_id');
        });
    }
}