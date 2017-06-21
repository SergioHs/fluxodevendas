<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    public function etapas()
    {
        return $this->belongsToMany('App\Etapa', 'vendas_etapas');
    }

    public function subEtapas()
    {
        return $this->belongsToMany('App\SubEtapa', 'vendas_subetapas');
    }

    public function apartamento()
    {
        return $this->belongsTo('App\Apartamento');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function status()
    {
        return $this->belongsTo('App\StatusVenda');
    }

}
