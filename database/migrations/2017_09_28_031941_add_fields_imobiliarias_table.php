<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsImobiliariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imobiliarias', function (Blueprint $table) {
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('endereco')->nullable();
			$table->integer('cidade_id')->unsigned()->default(4464);
            $table->foreign('cidade_id')->
              references('id')->on('cidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imobiliarias', function (Blueprint $table) {
            $table->dropColumn('telefone');
            $table->dropColumn('email');
            $table->dropColumn('endereco');
            $table->dropForeign(['cidade_id']);
            $table->dropColumn('cidade_id');
        });
    }
}
