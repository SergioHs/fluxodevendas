@extends('layouts.app')
@section('title', 'Trilhas de vendas')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3>Trilhas de vendas</h3>
        <div class="button-group stacked-for-small">
            <a class="button" href="{{action('TrilhaDeVendaController@create')}}">Cadastrar trilha</a>
            <a class="secondary button" href="{{action('EtapaController@create')}}">Cadastrar etapa</a>
            {{--<a class="secondary button" href="{{action('TrilhaDeVendaController@create')}}">Cadastrar sub-etapa</a>--}}
        </div>

    </div>
    <div class="auto cell">

    </div>
</div>
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        @if(count($trilhas) > 0)
        <table class="hover ajax-modal-table" data-modal="#trilha-detail-modal" data-route="/trilha/detail">
            <thead>
            <tr>

            </tr>
            </thead>
            <tbody  data-open="cliente-detail-modal">
            @foreach($trilhas as $t)
                <tr data-entity-id="{{$c->id}}">

                </tr>
            @endforeach
            </tbody>
        </table>
        @else
        @component('components.nenhum-resultado',['link' => 'TrilhaDeVendaController@create'])
        @endcomponent
        @endif
    </div>
</div>

<div class="reveal" id="trilha-detail-modal" data-reveal>

</div>
@endsection