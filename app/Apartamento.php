<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    protected $table = 'apartamentos';

    public function empreendimento()
    {
        return $this->belongsTo('App\Empreendimento');
    }

    public function vendas()
    {
        return $this->hasMany('App\Vendas', 'apartamento_id');
    }
}
