@extends('layouts.app')
@section('title', 'Cadastro de Vendedor')
@section('content')
    <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <h3>Cadastrar Vendedor</h3>
        </div>
    </div>
    <form method="post" action="{{action('VendedorController@store')}}">
        {{ csrf_field() }}
        <div class="grid-x grid-padding-x">
            <div class="medium-4 cell">
                <label>
                    Nome
                    <input type="text" name="nome" value="{{old('nome')}}">
                    @component('components.form-errors',['field' => 'nome'])
                    @endcomponent
                </label>
            </div>
            <div class="medium-4 cell">
                <label>
                    CPF
                    <input type="text" name="cpf_cnpj" value="{{old('cpf_cnpj')}}">
                </label>
            </div>
            <div class="medium-4 cell">
                <label>
                    Email
                    <input type="text" name="email" value="{{old('email')}}">
                    @component('components.form-errors',['field' => 'email'])
                    @endcomponent
                </label>
            </div>
            <div class="medium-4 cell">
                <label>
                    Telefone
                    <input type="text" name="telefone" value="{{old('telefone')}}">
                </label>
            </div>

            @component('components.cidades',['estados' => $estados])
            @endcomponent

            <div class="medium-8 cell">
                <label>
                    Observações
                    <textarea name="observacoes" rows="3" value="{{old('observacoes')}}"></textarea>
                </label>
            </div>
            <div class="medium-12 cell small-12">
                <button class="button" type="submit">Enviar</button>
            </div>
        </div>
    </form>
@endsection