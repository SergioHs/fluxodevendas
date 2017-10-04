@extends('layouts.logged')
@section('title', 'Imobiliárias')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display: inline;">Imobiliária</h3>
        <a class="button" href="{{action('ImobiliariaController@create')}}">Cadastrar</a>
    </div>
    <div class="auto cell">

    </div>
</div>
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        @if(count($registros) > 0)
        <table class="hover ajax-modal-table" data-modal="#imobiliaria-detail-modal" data-route="/imobiliaria/detail">
            <thead>
                <tr>
                    <td>Nome</td>
                    <td>Telefone</td>
                    <td>Endereço</td>
                    <td>E-mail</td>
                </tr>
            </thead>
            <tbody  data-open="cliente-detail-modal">
            @foreach($registros as $registro)
                <tr data-entity-id="{{$registro->id}}">
                    <td>{{$registro->nome}}</td>
                    <td>{{$registro->telefone}}</td>
                    <td>{{$registro->endereco}}</td>
                    <td>{{$registro->email}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
        @component('components.nenhum-resultado',['link' => 'ImobiliariaController@create'])
        @endcomponent
        @endif
    </div>
</div>
@endsection

<div class="reveal" id="imobiliaria-detail-modal" data-reveal>

</div>
