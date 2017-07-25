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
                <div class="medium-4 cell">
                    <label>
                        Descrição
                        <input type="text" name="descricao" value="{{old('descricao')}}">
                        @component('components.form-errors',['field' => 'descricao'])
                        @endcomponent
                    </label>
                </div>
                <div class="medium-4 cell">
                    <label>
                        Observações
                        <textarea rows="1">{{old('observacoes')}}</textarea>
                    </label>
                </div>
            </div>
            <div class="grid-x grid-padding-x grid-padding-y">
                <div class="medium-4 cell">
                    <p class="lead">Adicione etapas</p>
                    <select id="select-etapas">
                        <option value="">Selecione uma etapa</option>
                        @foreach($etapas as $e)
                            <option value="{{$e->id}}">{{$e->nome}}</option>
                        @endforeach
                    </select>
                    <input type="submit" class="button">
                </div>
                <div class="medium-4 cell">
                    <div id="etapas-selecionadas" class="hidden">
                        <p class="lead">Etapas selecionadas</p>


                    </div>
                </div>
            </div>

        </form>
    @endif
@endsection
@section('footer')
    <script type="text/javascript">
        $(function(){
            $("#select-etapas").on('change', function(ev){
                if(!$(this).val()) return;
                var nomeEtapa = $(this).children(':selected').text();
                var idEtapa = $(this).val();
                $("#etapas-selecionadas").removeClass("hidden");//.append($("<p></p>").text(nomeEtapa));
                $("#etapas-selecionadas").append($("<input>",{type:"hidden",value:idEtapa,id:nomeEtapa,name:"etapas[]"}));
                var $etapaCard = $("<div>",{class: 'card'});
                var $etapaCardContent = $("<div>",{class: 'card-section'})
                        .append($("<p>").text(nomeEtapa))
                        .append($("<button>",{class: 'button alert small', type: "button", text: "Remover", }));
                $etapaCard.append($etapaCardContent).appendTo($("#etapas-selecionadas"));
                $('option:selected', this).remove();
            });

            $("#etapas-selecionadas").on('click', 'button', function(){
                var removedEtapaText = $(this).siblings("p").text();
                var removedEtapaId = $("#etapas-selecionadas input#"+removedEtapaText).val();
                $("#select-etapas").append($("<option></option>",{value:removedEtapaId}).text(removedEtapaText));
                $("#etapas-selecionadas input#"+removedEtapaText).remove();
                $(this).closest("div.card").slideUp('fast');
            });
        })

    </script>
@endsection