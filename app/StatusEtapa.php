<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusEtapa extends Model
{
    protected $table = 'statusetapas';

    public function etapas()
    {
        return $this->hasMany('Etapas','statusetapas_id');
    }

    public function subEtapas()
    {
        return $this->hasMany('SubEtapas', 'statusetapas_id');
    }
}
