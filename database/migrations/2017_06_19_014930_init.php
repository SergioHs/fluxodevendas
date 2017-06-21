<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes',function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('statusetapas', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        Schema::create('etapas', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->integer('ordem');
            $table->timestamps();
        });

        Schema::create('subetapas', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->integer('etapa_id')->unsigned();
            $table->timestamps();

            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
        });

        Schema::create('empreendimentos', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->string('endereco')->nullable();
            $table->timestamps();
        });

        Schema::create('apartamentos', function(Blueprint $table){
            $table->increments('id');
            $table->string('numero');
            $table->integer('andar')->nullable();
            $table->string('bloco')->nullable();
            $table->integer('empreendimento_id')->unsigned();
            $table->timestamps();

            $table->foreign('empreendimento_id')->references('id')->on('empreendimentos')->onDelete('cascade');
        });

        Schema::create('statusvendas', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        Schema::create('vendas', function(Blueprint $table){
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('statusvendas_id')->unsigned();
            $table->integer('apartamento_id')->unsigned();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('statusvendas_id')->references('id')->on('statusvendas')->onDelete('cascade');
            $table->foreign('apartamento_id')->references('id')->on('apartamentos')->onDelete('cascade');

        });

        Schema::create('vendas_etapas', function(Blueprint $table){
            $table->integer('venda_id')->unsigned();
            $table->integer('etapa_id')->unsigned();
            $table->integer('statusetapas_id')->unsigned();

            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
            $table->foreign('statusetapas_id')->references('id')->on('statusetapas')->onDelete('cascade');

            $table->primary(['venda_id', 'etapa_id']);
        });

        Schema::create('vendas_subetapas', function(Blueprint $table){
            $table->integer('venda_id')->unsigned();
            $table->integer('subetapa_id')->unsigned();
            $table->integer('statusetapas_id')->unsigned();

            $table->primary(['venda_id', 'subetapa_id']);

            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');
            $table->foreign('subetapa_id')->references('id')->on('subetapas')->onDelete('cascade');
            $table->foreign('statusetapas_id')->references('id')->on('statusetapas')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('empreendimentos');
        Schema::dropIfExists('apartamentos');
        Schema::dropIfExists('etapas');
        Schema::dropIfExists('subetapas');
        Schema::dropIfExists('vendas');
        Schema::dropIfExists('vendas_etapas');
        Schema::dropIfExists('vendas_subetapas');
        Schema::dropIfExists('statusetapas');
        Schema::dropIfExists('statusvendas');

    }
}
