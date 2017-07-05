<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

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
