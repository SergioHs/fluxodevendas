@extends('layouts.app')
@section('title', 'Empreendimentos')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="auto cell">
        <h3 style="display: inline;">Empreendimentos</h3>
        <a class="button" href="{{action('EmpreendimentoController@create')}}">Cadastrar</a>
    </div>
</div>
<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        @if(count($empreendimentos) > 0)
            <table class="hover ajax-modal-table" data-modal="#empreendimento-detail-modal" data-route="/empreendimento/detail">
                <thead>
                <tr>
                    <td>Nome</td>
                    <td>Endereço</td>
                    <td>Cidade</td>
                </tr>
                </thead>
                <tbody  data-open="cliente-detail-modal">
                @foreach($empreendimentos as $e)
                    <tr data-entity-id="{{$e->id}}">
                        <td>{{$e->nome}}</td>
                        <td>{{$e->endereco}}</td>
                        <td>{{$e->cidade->cidade . " - " . $e->cidade->estado->sigla}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            @component('components.nenhum-resultado',['link' => 'EmpreendimentoController@create'])
            @endcomponent
        @endif
    </div>
</div>
<div class="reveal full" id="empreendimento-detail-modal" data-reveal>

</div>


{{--<p><a data-open="exampleModal2">Click me for a modal</a></p>--}}

{{--<!-- This is the first modal -->--}}
{{--<div class="reveal" id="exampleModal2" data-reveal>--}}
    {{--<h1>Awesome!</h1>--}}
    {{--<p class="lead">I have another modal inside of me!</p>--}}
    {{--<a class="button" data-open="exampleModal3">Click me for another modal!</a>--}}
    {{--<button class="close-button" data-close aria-label="Close reveal" type="button">--}}
        {{--<span aria-hidden="true">&times;</span>--}}
    {{--</button>--}}
    {{--<div class="reveal" id="exampleModal3" data-reveal data-multiple-opened="true">--}}
        {{--<h2>ANOTHER MODAL!!!</h2>--}}
        {{--<button class="close-button" data-close aria-label="Close reveal" type="button">--}}
            {{--<span aria-hidden="true">&times;</span>--}}
        {{--</button>--}}
    {{--</div>--}}
{{--</div>--}}
@endsection