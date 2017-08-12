@extends('layouts.app')
@section('title', 'Iniciar Venda')
@section('content')
<div class="grid-x grid-padding-y grid-padding-x">
    <div class="medium-12 cell">
        <h3>Iniciar venda </h3>
        <p>{{$apartamento->empreendimento->nome}}, apartamento {{$apartamento->numero}}, bloco {{$apartamento->bloco}},  {{$apartamento->andar}}&deg; andar</p>
    </div>
</div>
<form action="{{action("VendaController@store")}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="apartamento_id" value="{{$apartamento->id}}">
    <div class="grid-x grid-padding-y grid-padding-x">
        <div class="medium-4 cell">
            <label>Vendedor</label>
            <select id="select-vendedor" name="vendedor_id">
                @foreach($vendedores as $v)
                    <option value="{{$v->id}}">{{$v->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="medium-4 cell">
            <label>Cliente</label>
            <select name="cliente_id">
                @foreach($clientes as $c)
                    <option value="{{$c->id}}">{{$c->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="medium-4 cell">
            <label>Trilha de venda</label>
            <select name="trilhadevendas_id">
                @foreach($trilhas as $t)
                    <option value="{{$t->id}}">{{$t->nome}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid-x grid-padding-y grid-padding-x">
        <div class="medium-12 cell">
            <input type="submit" class="button primary" value="Iniciar venda">
        </div>
    </div>
</form>
@endsection
@section('footer')
    @if($cliente)
        <script type="text/javascript">
            $(function(){

            })
        </script>
    @endif
@endsection