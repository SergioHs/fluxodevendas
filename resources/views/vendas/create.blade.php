@extends('layouts.logged')
@section('title', 'Iniciar Venda')
@section('content')
<div class="grid-x grid-padding-y grid-padding-x">
    <div class="medium-12 cell">
        <h3>Iniciar venda </h3>
        <p>{{$apartamento->bloco->empreendimento->nome}}, apartamento {{$apartamento->numero}}, bloco {{$apartamento->bloco->nome}},  {{$apartamento->andar}}&deg; andar</p>
    </div>
    @component('components.form-errors',['field' => 'apartamento_id'])
    @endcomponent
</div>
<form action="{{action("VendaController@store")}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="apartamento_id" value="{{$apartamento->id}}">
    <div class="grid-x grid-padding-y grid-padding-x">
        <div class="medium-4 cell">
            <label>Vendedor</label>
            <select id="select-vendedor" name="user_id" @if (Auth::user()->permissao > 1) disabled @endif>
               @if (Auth::user()->permissao == 1)
                   @foreach($vendedores as $v)
                       <option value="{{$v->id}}">{{$v->name}}</option>
                   @endforeach
               @else
                  <option name="user_id" value="{{Auth::user()->id}}" selected>{{Auth::user()->name}}</option>
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
               @endif
            </select>
            @component('components.form-errors',['field' => 'vendedor_id'])
            @endcomponent
        </div>
        <div class="medium-4 cell">
            <label>Cliente</label>
            <select name="cliente_id">
                @foreach($clientes as $c)
                    <option value="{{$c->id}}">{{$c->nome}}</option>
                @endforeach
            </select>
            @component('components.form-errors',['field' => 'cliente_id'])
            @endcomponent
        </div>
        <div class="medium-4 cell">
            <label>Trilha de venda</label>
            <select name="trilhadevendas_id">
                @foreach($trilhas as $t)
                    <option value="{{$t->id}}">{{$t->nome}}</option>
                @endforeach
            </select>
            @component('components.form-errors',['field' => 'trilhadevendas_id'])
            @endcomponent
        </div>
                    
                        @if($apartamento->bloco->empreendimento->gerenciagaragem == 1)
                        <div class="large-12 cell container">
                    <div class="container">
                        <p class="lead">Garagem</p>
                @foreach($vagas as $vaga)
                    @if ($vaga->status===0)
                <a id="vaga {{$vaga->id}}" onclick="preencheVagaId(this, {{$vaga->id}}, event)" class="button small success">
                <b>Vaga: </b> {{$vaga->nome}}
                </a>
                    @endif
                    @if($vaga->status==1)
                    <a class="button small alert disabled">
                            <b>Vaga: </b> {{$vaga->nome}} 
                    </a>
                    @endif
                @endforeach 
        @endif                       
        <input id="vagaId" type="hidden" name="vaga_id">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </div>
        </div>
        </div>
        </div>
        </div>
    </div>

    <div class="grid-x grid-padding-y grid-padding-x">
        <div class="medium-12 cell">
            <input type="submit" class="button primary" value="Iniciar venda">
        </div>
   
    </div>
</form>
@endsection