<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <input type="hidden" value="{{$venda->id}}" id="input-venda-id">
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
    <div class="medium-12 cell" id="etapas-container">
        <h5>Etapas</h5>
            @if(isset($etapasConcluidas) && count($etapasConcluidas) > 0)
                <h6 style="color:#3adb76">Concluídas</h6>
                @foreach($etapasConcluidas as $e)
                    <div class="etapas-subetapas">
                        <div class="etapa">
                            <p> {{$e->nome}} </p>
                            @foreach($e->subetapas as $s)
                                <div class="sub-etapa">
                                    <div class="sub-etapa-content">
                                        <input name="subetapa-3" checked disabled title="Etapa já concluída" type="checkbox"><label class="has-line-through" for="subetapa-2">{{$s->nome}}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
            @if(isset($etapaEmAndamento) && count($etapaEmAndamento) > 0)
                <h6 style="color:#ffae00">Em andamento</h6>
                @foreach($etapaEmAndamento as $e)
                    <div class="etapas-subetapas">
                        <div class="etapa">
                            <p> {{$e->nome}} </p>
                            @foreach($e->subetapas as $s)
                            <div class="sub-etapa">
                                <div class="sub-etapa-content">
                                    <input name="subetapa-3" type="checkbox"><label for="subetapa-2">{{$s->nome}}</label>
                                </div>
                            </div>
                            @endforeach
                            <div>
                                <button class="button success small" id="concluir-etapa">Concluir etapa</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @if(isset($etapasEmEspera) && count($etapasEmEspera) > 0)
            <h6 style="color:#cc4b37">Esperando etapas anteriores</h6>
            @foreach($etapasEmEspera as $e)
                <div class="etapas-subetapas">
                    <div class="etapa">
                        <p> {{$e->nome}} </p>
                        @foreach($e->subetapas as $s)
                            <div class="sub-etapa">
                                <div class="sub-etapa-content">
                                    <input name="subetapa-3"  title="Conclua a etapa em andamento antes" disabled type="checkbox"><label for="subetapa-2">{{$s->nome}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="medium-12 cell">
        <button class="button alert small">Cancelar venda</button>
    </div>
</div>