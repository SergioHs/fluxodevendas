<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe da etapa <small>{{$etapa->nome}}</small></h3>
            </div>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Descrição</dt>
                <dd>{{$etapa->descricao ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Prazo</dt>
                <dd>{{$etapa->prazo . " dias" ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-12 cell">
            <p class="lead"><Sub-etapas></Sub-etapas></p>
            @component('components.etapas',['etapas' => $etapa->subetapas])
            @endcomponent
        </div>
    </div>
</div>