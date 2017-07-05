<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCpfcnpjFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function(Blueprint $table){
            $table->string("cpf_cnpj");
        });

        Schema::table('vendedores', function(Blueprint $table){
            $table->string("cpf_cnpj");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('cpf_cnpj');
        });

        Schema::table('vendedores', function (Blueprint $table) {
            $table->dropColumn('cpf_cnpj');
        });
    }
}
