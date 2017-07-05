@extends('layouts.app')
@section('title', 'Listar Clientes')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h3>Clientes</h3>
        <table class="hover">
            <thead>
                <tr>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>CNPJ/CPF</td>
                </tr>
            </thead>
            <tbody>
            @foreach($clientes as $c)
                <tr>
                    <td>{{$c->nome}}</td>
                    <td>{{$c->email}}</td>
                    <td>{{$c->cpf_cnpj}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endsection
    </div>
</div>
