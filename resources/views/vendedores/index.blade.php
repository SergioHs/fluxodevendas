@extends('layouts.logged')
@section('title', 'Vendedores')
@section('content')
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="auto cell">
            <h3 style="display: inline;">Vendedores</h3>
            <a class="button" href="{{action('VendedorController@create')}}">Cadastrar</a>
        </div>
        <div class="auto cell">

        </div>
    </div>
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="medium-12 cell">
            @if(count($vendedores) > 0)
            <table class="hover ajax-modal-table" data-modal="#vendedor-detail-modal" data-route="/vendedor/detail">
                <thead>
                <tr>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>Imobiliária</td>
                    <td>Situação</td>
                </tr>
                </thead>
                <tbody  data-open="vendedor-detail-modal">
                @foreach($vendedores as $v)
                    <tr data-entity-id="{{$v->id}}">
                        <td>{{$v->name}}</td>
                        <td>{{$v->email}}</td>
                        <td>{{$v->imobiliaria->nome}}</td>
                       @if($v->ativo)
                       <td><span class="label success">Ativo</span></td>
                       @else
                       <td><span class="label alert">Suspenso</span></td>
                       @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
            @component('components.nenhum-resultado',['link' => 'VendedorController@create'])
            @endcomponent
            @endif
        </div>
    </div>
<div class="reveal" id="vendedor-detail-modal" data-reveal>

</div>
@endsection