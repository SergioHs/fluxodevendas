<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe da venda </h3>
            </div>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Empreendimento</dt>
                <dd>{{$venda->apartamento->empreendimento->nome}}</dd>
                <dt>Apartamento</dt>
                <dd>{{$venda->apartamento->numero}}</dd>
                <dt>Trilha de venda</dt>
                <dd>{{$venda->trilhadevenda->nome}}</dd>
            </dl>
        </div>
        <div class="medium-6 cell">
            <dl>
            <dt>Proxima etapa</dt>
            <dd>{{$venda->etapas[0]->nome}}</dd>
            <dt>Prazo</dt>
            <dd>{{$venda->etapas[0]->prazo}}</dd>
            </dl>
        </div>
    </div>
</div>