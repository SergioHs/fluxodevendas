<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>

    <div class="medium-12 cell">
        <h3> Detalhe da venda </h3>
    </div>
    <div class="medium-6 cell">
        <dl>
            <dt>Cliente</dt>
            <dd>{{$venda->cliente->nome}}</dd>
        </dl>
    </div>
    <div class="medium-6 cell">
        <dl>
            <dt>Vendedor</dt>
            <dd>{{$venda->vendedor->nome}}</dd>
        </dl>
    </div>
    <div class="medium-6 cell">
        <dl>
            <dt>Empreendimento</dt>
            <dd>{{$venda->apartamento->empreendimento->nome}}</dd>

            <dt>Trilha de venda</dt>
            <dd>{{$venda->trilhadevenda->nome}}</dd>
        </dl>
    </div>
    <div class="medium-6 cell">
        <dl>
            <dt>Apartamento</dt>
            <dd>{{$venda->apartamento->numero}}, bloco {{$venda->apartamento->bloco}}, {{$venda->apartamento->andar}}&deg; andar</dd>
        </dl>
    </div>
    <div class="medium-12 cell">
        <h5>Etapas</h5>

            <div class="etapas-subetapas">
                <div class="etapa">
                    <p> Etapa </p>
                    <div class="subEtapa">
                        <div class="subEtapaContent">
                            <input name="subetapa-1" type="checkbox"><label for="subetapa-1">Sub Etapa 1Sub Etapa 1Sub Etapa 1Sub Etb Etapa 1 Etapa 1Etapa 1Etapa 1Etapa 1</label>
                        </div>
                    </div>
                    <div class="subEtapa">
                        <div class="subEtapaContent">
                            <input name="subetapa-2" type="checkbox"><label for="subetapa-2">Sub Etapa 2</label>
                        </div>
                    </div>
                    <div class="subEtapa">
                        <div class="subEtapaContent">
                            <input name="subetapa-3" type="checkbox"><label for="subetapa-2">Sub Etapa 3</label>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    <div class="medium-12 cell">
        <button class="button alert small">Cancelar venda</button>
    </div>
</div>