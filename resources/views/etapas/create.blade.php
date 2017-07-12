@extends('layouts.app')
@section('title','Cadastro de Etapa')
@section('content')
<div class="grid-x grid-padding-x">
    <div class="medium-12 cell">
        <h3>Cadastro de Etapa</h3>
    </div>
</div>
<form method="post" action="{{action('EtapaController@store')}}">
    {{csrf_field()}}
    <div class="grid-x grid-padding-x">
        <div class="medium-4 cell">
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
</form>
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="medium-4 cell">
            <ul class="accordion" data-accordion>
                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Vincule sub-etapas</a>
                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <input type="text" id="nome-subetapa">
                        <button class="button primary" id="btn-nova-subetapa">+ Nova Sub-Etapa</button>
                    </div>
                </li>
            </ul>
        </div>
        <div id="panel-subetapas" class="medium-4 cell">

        </div>
    </div>
</form>
@endsection
@section('footer')
<script type="text/javascript">
    $("btn#btn-nova-subetapa").on('click',function(ev){
        ev.preventDefault()
        var inputNome = $("input#nome-subetapa");
        alert(inputNome.val())
    })
</script>
@endsection
