<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendedorFieldsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->string('observacoes')->nullable();
            $table->string('cpf_cnpj')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telefone');
            $table->dropColumn('endereco');
            $table->dropColumn('observacoes');
            $table->dropColumn('cpf_cnpj');
			$table->dropColumn('cidade_id');
        });
    }
}
