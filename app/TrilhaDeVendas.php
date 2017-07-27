<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class TrilhaDeVendas extends Model
{
    protected $table = 'trilhasdevendas';

    public function vendas()
    {
        return $this->hasMany('App\Venda');
    }

    public function etapas()
    {
        return $this->belongsToMany('App\Etapa','trilhasdevendas_etapas','trilhadevendas_id', 'etapa_id');
    }

}