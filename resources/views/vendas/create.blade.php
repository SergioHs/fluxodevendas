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
                  <option value="{{Auth::user()->id}}" selected>{{Auth::user()->name}}</option>
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
    </div>
    <div class="grid-x grid-padding-y grid-padding-x">
        <div class="medium-12 cell">
            <input type="submit" class="button primary" value="Iniciar venda">
        </div>
    </div>
</form>
@endsection