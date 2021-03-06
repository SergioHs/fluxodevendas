@extends('layouts.logged')
@section('title', 'Trilhas de vendas')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell" id="titulo-top">
        <h3 style="display: inline">Trilhas de vendas</h3>
        <a class="button" href="{{action('TrilhaDeVendaController@create')}}">Cadastrar</a>
    </div>
    <div class="auto cell">

    </div>
</div>
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell" id="tabela-middle">
        @if(count($trilhas) > 0)
        <table class="hover ajax-modal-table" data-modal="#trilha-detail-modal" data-route="/trilhadevenda/detail">
            <thead>
                <tr>
                    <td> Nome </td>
                    <td> Descrição </td>
                    <td> Situação </td>
                </tr>
            </thead>
            <tbody  data-open="cliente-detail-modal">
            @foreach($trilhas as $t)
                <tr data-entity-id="{{$t->id}}">
                    <td>
                        {{$t->nome}}
                    </td>
                    <td>
                        {{$t->descricao}}
                    </td>
                    @if($t->ativo)
                    <td><span class="label success">Ativa</span></td>
                    @else
                    <td><span class="label alert">Suspensa</span></td>
                    @endif
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

<div class="reveal" id="trilha-detail-modal" data-reveal>

</div>
@endsection