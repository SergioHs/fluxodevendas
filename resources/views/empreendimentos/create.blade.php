@extends('layouts.app')
@section('title', 'Cadastrar Empreendimento')
@section('content')

<div class="grid-x grid-padding-y grid-padding-x">
    <div class="medium-12 cell">
        <h2>Cadastrar Empreendimento</h2>
    </div>
</div>
<form action="{{action('EmpreendimentoController@store')}}" method="POST">
    <div class="grid-x grid-padding-x">
        <div class="medium-6 cell">
            <label> Nome
                <input type="text">
            </label>
        </div>
        <div class="medium-6 cell">
            <label> Endereço
                <input type="text" name="endereco">
            </label>
        </div>
        <div class="medium-6 cell">
            <label> Estado
                <select type="text" name="estado">
                    <option> SC </option>
                    <option> SP </option>
                </select>
            </label>
        </div>
        <div class="medium-6 cell">
            <label> Cidade
                <input type="text" name="cidade">
            </label>
        </div>
    </div>
    <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <button type="submit" class="button">Enviar</button>
        </div>
    </div>
</form>


@endsection