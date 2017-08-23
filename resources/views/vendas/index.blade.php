@extends('layouts.logged')
@section('title', 'Vendas')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display:inline">Vendas</h3>
    </div>
    <div class="auto cell">

    </div>
</div>
<form method="post" action="{{action("VendaController@index")}}">
<div class="grid-x grid-padding-x grid-padding-y">
        {{csrf_field()}}
        <div class="medium-3 cell">
            <select name="vendedor_id">
                <option value="">Selecione um vendedor</option>
                @foreach($vendedores as $v)
                    <option value="{{$v->id}}">{{$v->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="medium-3 cell">
            <select name="cliente_id">
                <option value="">Selecione um cliente</option>
                @foreach($clientes as $c)
                    <option value="{{$c->id}}">{{$c->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="medium-3 cell">
            <select name="empreendimento_id">
                <option value="">Selecione um empreendimento</option>
                @foreach($empreendimentos as $e)
                    <option value="{{$e->id}}">{{$e->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="medium-3 cell">
            <button  type="submit" class="button secondary">Filtrar</button>
        </div>
    </div>
</form>

<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        @if(count($vendas) > 0)
        <table class="hover stack ajax-modal-table" data-modal="#venda-detail-modal" data-route="/venda/detail">
            <thead>
            <tr>
                <td> Cliente </td>
                <td> Empreendimento</td>
                <td> Apartamento </td>
                <td> Vendedor </td>
                <td> Status </td>
            </tr>
            </thead>
            <tbody  data-open="cliente-detail-modal">
            @foreach($vendas as $v)
            <tr data-entity-id="{{$v->id}}">
                <td>
                    {{$v->cliente->nome}}
                </td>
                <td>
                    {{$v->apartamento->bloco->empreendimento->nome}}
                </td>
                <td>
                    {{$v->apartamento->numero}}, bloco {{$v->apartamento->bloco->nome}}, {{$v->apartamento->andar}}&deg; andar
                </td>
                <td>
                    {{$v->vendedor->nome}}
                </td>
                <td>
                    @component('components.status-vendas',['status' => $v->status])@endcomponent
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @else
        @component('components.nenhum-resultado',['link' => 'TrilhaDeVendaController@create'])
        @endcomponent
        @endif
    </div>
</div>

<div class="reveal has-scroll" id="venda-detail-modal" data-reveal>

</div>
@endsection