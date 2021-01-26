<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    protected $table = 'blocos';
    protected $guarded = ['id'];

    public function empreendimento()
    {
        return $this->belongsTo('App\Empreendimento');
    }

    public function apartamentos()
    {
        return $this->hasMany('App\Apartamento');
    }

}
