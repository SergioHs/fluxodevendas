@extends('layouts.logged')
@section('title','Pendências')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display:inline">Pendências</h3>
        {{--<a class="button" href="{{action('VendaController@create')}}">Iniciar venda</a>--}}
    </div>
    <div class="auto cell">

    </div>
</div>

@if($nenhumaPendencia)
<div class="callout warning">
    <h5>Você não tem nenhuma pendência</h5>
</div>
@endif

@if(count($vencidas) > 0)
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h4>Vencidas</h4>
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
            @foreach($vencidas as $v)
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
                        {{$v->user->name}}
                    </td>
                    <td>
                        @component('components.status-vendas',['status' => $v->status])@endcomponent
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if(count($emVencimento) > 0)
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h4>Vence hoje</h4>
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
            @foreach($emVencimento as $v)
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
                        {{$v->user->name}}
                    </td>
                    <td>
                        @component('components.status-vendas',['status' => $v->status])@endcomponent
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if(count($venceLogo) > 0)
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h4>Vence à partir de amanhã</h4>
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
            @foreach($venceLogo as $v)
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
                        {{$v->user->name}}
                    </td>
                    <td>
                        @component('components.status-vendas',['status' => $v->status])@endcomponent
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if(count($venceTresDias) > 0)
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h4>Vence à partir de 3 dias</h4>
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
            @foreach($venceTresDias as $v)
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
                        {{$v->user->name}}
                    </td>
                    <td>
                        @component('components.status-vendas',['status' => $v->status])@endcomponent
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if(count($venceUmaSemana) > 0)
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h4>Vence à partir de 1 semana</h4>
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
            @foreach($venceUmaSemana as $v)
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
                        {{$v->user->name}}
                    </td>
                    <td>
                        @component('components.status-vendas',['status' => $v->status])@endcomponent
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="reveal has-scroll" id="venda-detail-modal" data-reveal>

</div>
@endsection