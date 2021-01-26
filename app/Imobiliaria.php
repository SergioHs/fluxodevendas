<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imobiliaria extends Model
{
    protected $guarded = ['id'];
   
    public function vendedores()
    {
        return $this->hasMany('App\User');
    }

    public function cidade()
    {
        return $this->belongsTo('App\Cidade');
    }
}
