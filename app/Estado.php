<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = ['nome'];
    public $timestamps = false;

    public function cidades()
    {
        return $this->hasMany('App\Cidade');
    }

    public static function getCidades($id)
    {
        return static::find($id)->cidades;
    }

    public function scopeCidadesPorId($query, $id)
    {
        return $query->find($id)->cidades;
    }

}