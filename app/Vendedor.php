<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
