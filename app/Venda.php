<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $guarded = ['id'];

    public function etapas()
    {
        return $this->belongsToMany('App\Etapa', 'vendas_etapas', 'venda_id', 'etapa_id')->withPivot(['statusetapas_id','prazo']);
    }

    public function subEtapas()
    {
        return $this->belongsToMany('App\SubEtapa', 'vendas_subetapas', 'venda_id', 'subetapa_id')->withPivot('statusetapas_id');
    }

    public function apartamento()
    {
        return $this->belongsTo('App\Apartamento');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function vendedor()
    {
//        return $this->belongsTo('App\Vendedor');
//       dd($this->belongsTo('App\User'));
       return $this->belongsTo('App\User');
    }

    public function user()
    {
//        return $this->belongsTo('App\Vendedor');
//       dd($this->belongsTo('App\User'));
       return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\StatusVenda','statusvendas_id');
    }

    public function trilhaDeVenda()
    {
        return $this->belongsTo('App\TrilhaDeVendas', 'trilhadevendas_id');
    }

}
