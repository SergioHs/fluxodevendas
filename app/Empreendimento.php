<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empreendimento extends Model
{
    protected $table = 'empreendimentos';

    public function blocos()
    {
        return $this->hasMany('App\Bloco');
    }
    public function vagas()
    {
        return $this->hasMany('App\Vaga');
    }

    public function cidade()
    {
        return $this->belongsTo('App\Cidade');
    }
}
