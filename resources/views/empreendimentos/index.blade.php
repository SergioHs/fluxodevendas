@extends('layouts.app')
@section('title', 'Empreendimentos')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display: inline;">Empreendimentos</h3>
        <a class="button" href="{{action('EmpreendimentoController@create')}}">Cadastrar</a>
    </div>
</div>
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        @if(count($empreendimentos) > 0)
            <table class="hover ajax-modal-table" data-modal="#empreendimento-detail-modal" data-route="/empreendimento/detail">
                <thead>
                <tr>
                    <td>Nome</td>
                    <td>Endereço</td>
                    <td>Cidade</td>
                </tr>
                </thead>
                <tbody  data-open="cliente-detail-modal">
                @foreach($empreendimentos as $e)
                    <tr data-entity-id="{{$e->id}}">
                        <td>{{$e->nome}}</td>
                        <td>{{$e->endereco}}</td>
                        <td>{{$e->cidade->cidade . " - " . $e->cidade->estado->sigla}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            @component('components.nenhum-resultado',['link' => 'EmpreendimentoController@create'])
            @endcomponent
        @endif
    </div>
</div>
<div class="reveal full" id="empreendimento-detail-modal" data-reveal data-multiple-opened="true">

</div>

@endsection