<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusVenda extends Model
{
    protected $table = 'statusvendas';

    public function vendas()
    {
        return $this->hasMany('App\Venda', 'statusvendas_id');
    }
}
