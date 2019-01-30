<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGaragem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empreendimentos', function (Blueprint $table) {
            $table->boolean('gerenciagaragem')->default(0);
        });
        Schema::create('vagas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('status')->default(0);
            $table->integer('empreendimento_id')->unsigned();
            $table->timestamps();
            $table->foreign('empreendimento_id')->references('id')->on('empreendimentos');
        });

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
