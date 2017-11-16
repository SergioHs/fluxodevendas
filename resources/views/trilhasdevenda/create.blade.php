@extends('layouts.logged')
@section('title','Cadastro de Trilha de Vendas')
@section('content')
    <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <h3>Cadastrar Trilha de Vendas</h3>
        </div>
    </div>

    @if($cadastrarEtapas)
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <div class="callout secondary">
                    <h5>Você ainda não cadastrou nenhuma etapa</h5>
                    <p>Cadastre uma nova <a href="{{action('EtapaController@create')}}">aqui</a></p>
                </div>
            </div>
        </div>
    @else
        <form method="post"  id="trilhadevenda-form" action="{{action('TrilhaDeVendaController@store')}}">
            {{csrf_field()}}
            @if(isset($trilha))
                <input type="hidden" name="id" value="{{$trilha->id}}">
            @endif
            <div class="grid-x grid-padding-x grid-padding-y">
                <div class="medium-4 cell">
                    <label>
                        Nome
                        <input type="text" name="nome" value="{{old('nome') ?: $trilha->nome ?? ''}}">
                        @component('components.form-errors',['field' => 'nome'])
                        @endcomponent
                    </label>
                </div>
                <div class="medium-4 cell">
                    <label>
                        Descrição
                        <input type="text" name="descricao" value="{{old('descricao') ?: $trilha->descricao ?? ''}}">
                        @component('components.form-errors',['field' => 'descricao'])
                        @endcomponent
                    </label>
                </div>
                <div class="medium-4 cell">
                    <label>
                        Observações
                        <textarea name="observacoes" rows="1">{{old('observacoes') ?: $trilha->observacoes ?? ''}}</textarea>
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
                    <input type="submit" class="button" value="Cadastrar">
                </div>
                <div class="medium-4 cell">
                    <div id="etapas-selecionadas" class="{{isset($trilha) ?  '' : 'hidden'}} draggable">
                        <p>Etapas selecionadas</p>
                        @if(isset($trilha))
                            @foreach($trilha->etapas as $e)
                            <div class="card" draggable="true" id="card-{{str_replace(" ","",$e->nome)}}">
                                <input type="hidden" name="etapas[]" id="{{str_replace(" ","",$e->nome)}}" value="{{$e->id}}">
                                <div class="card-section">
                                    <div class="grid-x">
                                        <div class="medium-11 cell"><p>{{$e->nome}}</p></div>
                                        <div class="medium-1 cell">
                                            <button class="button alert tiny" type="button">X</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif

                    </div>
                </div>
           
               <div class="form-group medium-4 cell">
                  <label for="ativo">Situação da trilha</label>
                  <input type="hidden" name="ativo" value="0">
                  @if(isset($trilha))
                  <input type="checkbox" name="ativo" value="1" @if ($trilha->ativo == 1) checked @endif> Ativa<br>
                  @else
                  <input type="checkbox" name="ativo" value="1" checked> Ativa<br>
                  @endif
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
                console.log(nomeEtapa.replaceAll(" ",""));
                var idEtapa = $(this).val();
                $("#etapas-selecionadas").fadeIn();
                $("#etapas-selecionadas").removeClass("hidden");//.append($("<p></p>").text(nomeEtapa));
                //$("#etapas-selecionadas");
                var $etapaCard = $("<div>",{class: 'card', draggable: true, id: 'card-'+(nomeEtapa.replaceAll(" ",""))});
                var $etapaGrid = $("<div></div>",{class: "grid-x"});
                var $etapaTextWrapper = $("<div></div>", {class : "medium-11 cell"}).append($("<p>").text(nomeEtapa));
                var $etapaBtnWrapper = $("<div></div>",{class: "medium-1 cell"}).append($("<button>",{class: 'button alert tiny', type: "button", text: "X", }));
                $etapaGrid.append($etapaTextWrapper).append($etapaBtnWrapper);
                var $etapaCardContent = $("<div>",{class: 'card-section'})
                        .append($etapaGrid);
                $etapaCard.append($("<input>",{type:"hidden",value:idEtapa,id:nomeEtapa.replaceAll(" ",""),name:"etapas[]"})).append($etapaCardContent).appendTo($("#etapas-selecionadas"));
                $('option:selected', this).remove();
            });

            $("#etapas-selecionadas").on('click', 'button', function(){
                //ARRUMAR
                var removedEtapaText = $(this).parent().prev().first("p").text();
                var removedEtapaId = $("#etapas-selecionadas input#"+(removedEtapaText.replaceAll(" ",""))).val();
                $("#select-etapas").append($("<option></option>",{value:removedEtapaId}).text(removedEtapaText));
                $("input#"+(removedEtapaText.replaceAll(" ",""))).remove();
                $(this).closest("div.card").remove();
            });

            var $container = $("#etapas-selecionadas");

            $container.on('dragover', function (ev) {
                ev.preventDefault();
            });

            $("#etapas-selecionadas").on('dragenter','.card', function (ev) {//
                var $ghostItem = $("<div></div>",{class: 'ghost arrow-right'});
                $(this).after($ghostItem);
            });

            $("#etapas-selecionadas").on('dragleave','.card', function (ev) {
                $(this).next(".ghost").remove();
            });

            $container.on('drop', '.card', function (ev) {
                ev.preventDefault();

                var $srcElt = $("#" + ev.originalEvent.dataTransfer.getData("id"));

                var $targetElt = $(this);

                $targetElt.next(".ghost").remove();
                $targetElt.after($srcElt);
                console.log("dropou")
            });

            $container.on('dragstart', '.card', function (ev) {
                console.log('dragstart')
                var $target = $(ev.target);
                $target.css('opacity', '0.5');
                ev.originalEvent.dataTransfer.setData("id", $target.attr("id"));
            });

            $container.on('dragend', '.card', function (ev) {
                $(ev.target).css('opacity', '1');
            })

            var submeteu = false;
            $("#trilhadevenda-form").on('submit', function(ev){

                if(!submeteu){
                    ev.preventDefault();
                    submeteu = true;

                    $(this).trigger('submit');
                }



            })


        })

    </script>
@endsection