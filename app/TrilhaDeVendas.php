<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 27/06/17
 * Time: 21:50
 */

namespace app;

use Illuminate\Database\Eloquent\Model;

class TrilhaDeVendas extends Model
{
    protected $table = 'trilhasdevendas';

    public function vendas()
    {
        return $this->hasMany('App\Venda');
    }

    public function etapas()
    {
        return $this->belongsToMany('App\Etapas');
    }

    public function subEtapas()
    {
        return $this->belongsToMany('App\SubEtapas');
    }
}