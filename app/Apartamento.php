<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    protected $table = 'apartamentos';
    protected $guarded = ['id'];

    public function empreendimento()
    {
        return $this->belongsTo('App\Empreendimento');
    }

    public function vendas()
    {
        return $this->hasMany('App\Venda', 'apartamento_id');
    }
}
