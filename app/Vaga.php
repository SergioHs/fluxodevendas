<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $table = 'vagas';
    protected $guarded = ['id'];
    //
    public function empreendimento()
    {
        return $this->belongsTo('App\Empreendimento');
    }


}

?>