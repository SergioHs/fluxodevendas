@extends('layouts.app')
@section('title', 'Listar Vendedores')
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

            <table class="hover ajax-modal-table" data-modal="#vendedor-detail-modal" data-route="/vendedor/detail">
                <thead>
                <tr>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>CNPJ/CPF</td>
                </tr>
                </thead>
                <tbody  data-open="vendedor-detail-modal">
                @foreach($vendedores as $v)
                    <tr data-entity-id="{{$v->id}}">
                        <td>{{$v->nome}}</td>
                        <td>{{$v->email}}</td>
                        <td>{{$v->cpf_cnpj}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endsection
        </div>
    </div>

    <div class="reveal" id="vendedor-detail-modal" data-reveal>

    </div>
