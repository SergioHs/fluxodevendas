@extends('layouts.logged')
@section('title', 'Trilhas de vendas')
@section('content')
<div class="grid-x grid-padding-x grid-padding-y">
   <div class="auto cell" id="titulo-top">
      <h3>Configuração dos totais da trilha <small>{{$trilha->nome}}</small></h3>
   </div>
   <div class="auto cell">
   </div>
</div>
<div class="medium-12 cell" id="tabela-middle">
   <div class="medium-12 cell">
      <p class="lead">Etapas</p>
      <form method="post"  id="trilhadevenda-form" action="{{action('TrilhaDeVendaController@salvarConfig')}}">
         {{csrf_field()}}
         <input type="hidden" name="id" value="{{$trilha->id}}">
         <table class="hover" id="config-etapas">
            <thead>
               <tr>
                  <td>Nome</td>
                  <td>Descrição</td>
                  <td>Totalizar</td>
               </tr>
            </thead>
            <tbody>
               @foreach($trilha->etapas as $e)
               <tr>
                  <td>{{$e->nome}}</td>
                  <td>{{$e->descricao ?: "Não definido" }}</td>
                  <td>
                  <input type="hidden" name="checkbox[{{$e->pivot->etapa_id}}]" value="0">
                  <input type="checkbox" name="checkbox[{{$e->pivot->etapa_id}}]" value="1" 
                         @if ($e->pivot->totalizar == 1) checked @endif>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         <input type="submit" class="button" value="Salvar">
      </form>
   </div>
</div>

<div class="reveal" id="trilha-detail-modal" data-reveal>
</div>
@endsection