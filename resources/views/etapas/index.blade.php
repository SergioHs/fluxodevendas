@extends('layouts.logged')
@section('title','Etapas')
@section('content')
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="auto cell">
            <h3 style="display:inline">Etapas</h3>
            <a class="primary button" href="{{action('EtapaController@create')}}">Cadastrar</a>
        </div>
        <div class="auto cell">

        </div>
    </div>

    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="medium-12 cell">
            @if(count($etapas) > 0)
                <table class="hover stack ajax-modal-table" data-modal="#etapa-detail-modal" data-route="/etapa/detail">
                    <thead>
                    <tr>
                        <td> Nome</td>
                        <td> Descrição</td>
                    </tr>
                    </thead>
                    <tbody  data-open="cliente-detail-modal">
                    @foreach($etapas as $e)
                        <tr data-entity-id="{{$e->id}}">
                            <td>
                                {{$e->nome}}
                            </td>
                            <td>
                                {{$e->descricao}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                @component('components.nenhum-resultado',['link' => 'EtapaController@create'])
                @endcomponent
            @endif
        </div>
    </div>

    <div class="reveal has-scroll" id="etapa-detail-modal" data-reveal>

    </div>
@endsection