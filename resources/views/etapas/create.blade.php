@extends('layouts.logged')
@section('title','Cadastro de Etapa')
@section('content')

<div class="grid-x grid-padding-x grid-padding-y">
    <div class="medium-12 cell">
        <h3>Cadastro de Etapa</h3>
    </div>
</div>
<form method="post" id="etapa-form" action="{{action('EtapaController@store')}}">
    {{csrf_field()}}
    <div class="grid-x grid-padding-x">
        <div class="medium-4 cell">
            <div class="hidden" id="subetapas-input-container">

            </div>
            <label>
                Nome
                <input type="text" name="nome" required>
                @component('components.form-errors',['field' => 'nome'])
                @endcomponent
            </label>
        </div>
        <div class="medium-4 cell">
            <label>
                Prazo (em dias)
                <input type="number" name="prazo" required>
                @component('components.form-errors',['field' => 'prazo'])
                @endcomponent
            </label>
        </div>
    </div>

    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="medium-4 cell">
            <ul class="accordion" data-accordion>
                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Vincule sub-etapas</a>
                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content is-active" data-tab-content>
                        <input type="text" id="nome-subetapa" title="Nome da sub-etapa">
                        <div id="nome-subetapa-error" class="callout alert small hidden">

                        </div>
                        <button class="button secondary" type="button" id="btn-nova-subetapa">+ Nova Sub-Etapa</button>
                    </div>
                </li>
            </ul>
            <input type="submit" class="button" value="Cadastrar">
        </div>
        <div id="panel-subetapas" class="medium-4 cell">

        </div>
    </div>

</form>



@endsection
@section('footer')
<script type="text/javascript">
$(document).ready(function(){

    var subEtapas = [];

    $("#btn-nova-subetapa").on('click',function(ev){
        ev.preventDefault();
        var inputNome = $("#nome-subetapa");
        if(inputNome.val().length == 0){
            $("#nome-subetapa-error").text("Preencha um nome").slideDown('fast');
        } else if(_.find(subEtapas,function(i){return i.nome == inputNome.val()})){
            $("#nome-subetapa-error").text("Esse nome já está em uso").slideDown('fast');
        } else {
            var $subEtapaCard = $("<div>",{class: 'card'});
            var $subEtapaCardContent = $("<div>",{class: 'card-section'})
                    .append($("<p>").text(inputNome.val()))
                    .append($("<button>",{class: 'button alert small', type: "button", text: "Remover", }));
            $subEtapaCard.append($subEtapaCardContent).appendTo($("#panel-subetapas"));
            subEtapas.push({nome: inputNome.val()});
            inputNome.val("");
            $("#nome-subetapa-error").slideUp('fast');
        }
    });

    $("#panel-subetapas").on('click', 'button', function(){
        var subEtapaText = $(this).siblings("p").text();
        subEtapas = _.reject(subEtapas,function(i){return i.nome == subEtapaText});
        $(this).closest("div.card").slideUp('fast');
    });

    var submeteu = false;

    $("#etapa-form").on('submit', function(ev) {
        if (!submeteu) {
            ev.preventDefault();
            _.each(subEtapas, function (el) {
                $("div#subetapas-input-container").append("<input type='hidden' name='subetapas[]' value='"+el.nome+"'>");
            });
            submeteu = true;
            $(this).trigger('submit');
        }
    });
});

</script>
@endsection
