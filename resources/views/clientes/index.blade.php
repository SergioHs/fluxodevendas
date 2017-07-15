@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display: inline;">Clientes</h3>
        <a class="button" href="{{action('ClienteController@create')}}">Cadastrar</a>
    </div>
    <div class="auto cell">

    </div>
</div>
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        @if(count($clientes) > 0)
        <table class="hover ajax-modal-table" data-modal="#cliente-detail-modal" data-route="/cliente/detail">
            <thead>
                <tr>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>CNPJ/CPF</td>
                </tr>
            </thead>
            <tbody  data-open="cliente-detail-modal">
            @foreach($clientes as $c)
                <tr data-entity-id="{{$c->id}}">
                    <td>{{$c->nome}}</td>
                    <td>{{$c->email}}</td>
                    <td>{{$c->cpf_cnpj}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
        @component('components.nenhum-resultado',['link' => 'ClienteController@create'])
        @endcomponent
        @endif
    </div>
</div>
@endsection

<div class="reveal" id="cliente-detail-modal" data-reveal>

</div>
