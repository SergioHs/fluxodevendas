@extends('layouts.app')
@section('title', 'Empreendimentos')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display: inline;">Empreendimentos</h3>
        <a class="button" href="{{action('EmpreendimentoController@create')}}">Cadastrar</a>
    </div>
    <div class="auto cell">

    </div>
</div>
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">

    </div>
</div>
@endsection