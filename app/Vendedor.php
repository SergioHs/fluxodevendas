<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// ******************************************************************************** //
// Esta classe não está mais sendo utilizada, pois foi substituída pela classe User //
// Mantida para evitar erros devido à pressa                                        //
// TODO: testar se está sendo utilizada em algum ponto do programa e excluir        //
// ******************************************************************************** //

class Vendedor extends Model
{
    protected $table = 'vendedores';

    protected $guarded = ['id'];

    public function vendas()
    {
        return $this->hasMany('App\Venda');
    }

    public function cidade()
    {
        return $this->belongsTo('App\Cidade');
    }
}
