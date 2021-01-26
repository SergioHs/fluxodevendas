<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubEtapa extends Model
{
    protected $table = 'subetapas';
    protected $guarded = ['id'];

    public function vendas()
    {
        return $this->belongsToMany('App\Vendas', 'vendas_subetapas');
    }

    public function etapa()
    {
        return $this->belongsTo('App\Etapa');
    }

}
