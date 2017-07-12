@extends('layouts.app')
@section('title','Cadastro de Trilha de Vendas')
@section('content')
<div class="grid-x grid-padding-x">
    <div class="medium-12 cell">
        <h3>Cadastrar Trilha de Vendas</h3>
    </div>
</div>

@if(count($etapas) == 0)
<div class="grid-x grid-padding-x">
    <div class="medium-12 cell">
        <div class="callout secondary">
            <h5>Você ainda não cadastrou nenhuma etapa</h5>
            <p>Cadastre uma nova <a href="{{action('EtapaController@create')}}">aqui</a></p>
        </div>
    </div>
</div>
@else
<form method="post" action="{{action('TrilhaDeVendaController@store')}}">
{{csrf_field()}}

<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-4 cell">
        <label>
            Nome
            <input type="text" name="nome" value="{{old('nome')}}">
            @component('components.form-errors',['field' => 'nome'])
            @endcomponent
        </label>
    </div>
    <div class="medium-12 cell">
        <p class="lead">Adicione etapas</p>
    </div>

    {{--<div class="medium-4 cell">--}}
        {{--<label>--}}
            {{--Observações--}}
            {{--<textarea rows="4">{{old('observacoes')}}</textarea>--}}
        {{--</label>--}}
    {{--</div>--}}
</div>
</form>
@endif
@endsection