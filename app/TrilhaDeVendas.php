<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class TrilhaDeVendas extends Model
{
    protected $table = 'trilhasdevendas';

    public function vendas()
    {
        return $this->hasMany('App\Venda','trilhadevendas_id');
    }

    public function etapas()
    {
        return $this->belongsToMany('App\Etapa','trilhasdevendas_etapas','trilhadevendas_id', 'etapa_id')->withPivot('ordem', 'totalizar');
    }

   public function totalizaEtapas(){
      return $this->etapas()->wherePivot('totalizar', '=', 1)->count();
   }

   public function etapasComTotal(){
      return $this->etapas()->wherePivot('totalizar', '=', 1)->get()->toArray();
   }
}