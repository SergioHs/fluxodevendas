<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    protected $table = 'etapas';

    public function vendas()
    {
        return $this->belongsToMany('App\Vendas', 'vendas_etapas');
    }

    public function subEtapas()
    {
        return $this->hasMany('App\SubEtapa');
    }

    public function trilhasDeVendas()
    {
        return $this->belongsToMany('App\TrilhaDeVenda');
    }
}
