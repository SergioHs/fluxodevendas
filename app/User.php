<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'endereco', 'telefone', 'observacoes', 'cpf_cnpj', 'ativo', 'permissao',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function vendas()
    {
        return $this->hasMany('App\Venda');
    }

    public function cidade()
    {
        return $this->belongsTo('App\Cidade');
    }

    public function imobiliaria()
    {
        return $this->belongsTo('App\Imobiliaria');
    }
}
