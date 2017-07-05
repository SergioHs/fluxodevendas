@extends('layouts.app')
@section('title', 'Cadastrar Cliente')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h2>Cadastrar Cliente</h2>
    </div>
</div>
<form method="post" action="{{url('/cliente/store')}}">
{{ csrf_field() }}
<div class="grid-x grid-padding-x">
    <div class="medium-4 cell">
        <label>
            Nome
            <input type="text" name="nome">
        </label>
    </div>
    <div class="medium-4 cell">
        <label>
            CPF
            <input type="text" name="cpf_cnpj">
        </label>
    </div>
    <div class="medium-4 cell">
        <label>
            Email
            <input type="text" name="email">
        </label>
    </div>
    <div class="medium-4 cell">
        <label>
            Telefone
            <input type="text" name="telefone">
        </label>
    </div>

    @component('components.cidades',['estados' => $estados])
    @endcomponent

    <div class="medium-8 cell">
        <label>
            Observações
            <textarea name="observacoes" rows="3"></textarea>
        </label>
    </div>
    <div class="medium-12 cell small-12">
        <button class="button" type="submit">Enviar</button>
    </div>
</div>
</form>
@endsection