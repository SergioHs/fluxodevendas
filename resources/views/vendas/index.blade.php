@extends('layouts.logged')
@section('title', 'Vendas')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display:inline">Vendas</h3>
        {{--<a class="button" href="{{action('VendaController@create')}}">Iniciar venda</a>--}}
    </div>
    <div class="auto cell">

    </div>
</div>


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
                    {{$v->apartamento->empreendimento->nome}}
                </td>
                <td>
                    {{$v->apartamento->numero}}, bloco {{$v->apartamento->bloco}}, {{$v->apartamento->andar}}&deg; andar
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