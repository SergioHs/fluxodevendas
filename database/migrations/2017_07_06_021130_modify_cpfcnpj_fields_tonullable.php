<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCpfcnpjFieldsTonullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendedores', function(Blueprint $table){
           $table->string('cpf_cnpj')->nullable()->change();
        });

        Schema::table('clientes', function(Blueprint $table){
            $table->string('cpf_cnpj')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendedores', function(Blueprint $table){
            $table->string('cpf_cnpj')->change();
        });

        Schema::table('clientes', function(Blueprint $table){
            $table->string('cpf_cnpj')->change();
        });
    }
}
