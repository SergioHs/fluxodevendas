<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empreendimento extends Model
{
    protected $table = 'empreendimentos';

    public function apartamentos()
    {
        return $this->hasMany('App\Apartamento');
    }
}
