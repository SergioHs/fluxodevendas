<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlocos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocos', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->integer('empreendimento_id')->unsigned();

            $table->foreign('empreendimento_id')->references('id')->on('empreendimentos');
        });

        Schema::table('apartamentos', function(Blueprint $table){
            $table->dropForeign('apartamentos_empreendimento_id_foreign');
            $table->dropColumn('empreendimento_id');
            $table->dropColumn('bloco');
            $table->integer('bloco_id')->unsigned();
            $table->foreign('bloco_id')->references('id')->on('blocos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blocos');

        Schema::table('apartamentos', function(Blueprint $table){
            $table->dropForeign('bloco_id');
            $table->integer('empreendimento_id')->unsigned();
            $table->string('bloco');
            $table->foreign('empreendimento_id')->references('id')->on('empreendimentos');
        });
    }
}
