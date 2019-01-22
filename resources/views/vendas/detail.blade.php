<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <input type="hidden" value="{{$venda->id}}" id="input-venda-id">
    <div class="medium-12 cell">
        <h3> Detalhe da venda <small>#{{$venda->id}}</small></h3>
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
            <dd>{{$venda->user->name}}</dd>
        </dl>
    </div>
    <div class="medium-6 cell">
        <dl>
            <dt>Empreendimento</dt>
            <dd>{{$venda->apartamento->bloco->empreendimento->nome}}</dd>

            <dt>Trilha de venda</dt>
            <dd>{{$venda->trilhadevenda->nome}}</dd>
        </dl>
    </div>
    <div class="medium-6 cell">
        <dl>
            <dt>Apartamento</dt>
            <dd>{{$venda->apartamento->numero}}, bloco {{$venda->apartamento->bloco->nome}}, {{$venda->apartamento->andar}}&deg; andar</dd>
            <dt> Status </dt>
            <dd>@component('components.status-vendas',['status' => $venda->status]) @endcomponent</dd>
        </dl>
    </div>
    @if($venda->vaga)

    <div class="medium-6 cell">
        <dt><b>Vaga Escolhida</b></dt>
        <dd>{{$venda->vaga->nome}} </dd>        
        <br>
    @endif

    </div>
   @if(isset($etapasEmAtraso) && count($etapasEmAtraso) > 0)
    <div class="medium-12 cell">
        <dl>
            <dt>Justificativa de atraso</dt>
            <dd id='justificativa'>
               
            @if(isset($venda->justificativa))
               <p id="p-justificativa">{{$venda->justificativa}}<small><em> - atualizado em: {{date('d/m/Y',strtotime($venda->updated_at))}}</em></small></p>
               @if (Auth::user()->id == $venda->user_id)
                  <button class="button warning small" id="editar-justificativa">Editar</button>
                  <button class="button alert small" id="excluir-justificativa">Excluir</button>
               @endif
            @else
               Sem justificativa
               
               @if (Auth::user()->id == $venda->user_id)
                  <div class="medium-4">
                     <button class="button success small" id="justificar">Justificar</button>
                  </div>
               @endif
            @endif
            </dd>
       </dl>
    </div>
    @endif
  
    <div class="medium-12 cell" id="etapas-container">
        <h5>Etapas</h5>
            @if(isset($etapasConcluidas) && count($etapasConcluidas) > 0)
                <h6 style="color:#3adb76">Concluídas</h6>
                @foreach($etapasConcluidas as $e)
                    <div class="etapas-subetapas">
                        <div class="etapa">
                            <p> {{$e->nome}} </p>
                            @foreach($venda->subetapas as $s)
                                @if($s->etapa_id == $e->id)
                                    <div class="sub-etapa">
                                        <div class="sub-etapa-content">
                                            <input name="subetapa-3" value="{{$s->id}}" {{$s->pivot->statusetapas_id == \App\StatusEtapasEnum::COMPLETA ? "checked" : ""}} disabled title="Etapa já concluída" type="checkbox"><label class="{{$s->pivot->statusetapas_id == \App\StatusEtapasEnum::COMPLETA ? "has-line-through" : "" }}" for="subetapa-2">{{$s->nome}}</label>
                                        </div>
                                    </div>
                                @endif
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
                            <p>Prazo: {{ date('d/m/Y',strtotime($e->pivot->prazo))}}</p>
                            @foreach($venda->subetapas as $s)
                                @if($s->etapa_id == $e->id)
                                    <div class="sub-etapa">
                                        <div class="sub-etapa-content">
                                            <input name="subetapa-3" {{$venda->status->id != \App\StatusVendasEnum::RESERVADO ? "disabled" : ""}} {{$s->pivot->statusetapas_id == \App\StatusEtapasEnum::COMPLETA ? "checked" : ""}} value="{{$s->id}}" type="checkbox"><label for="subetapa-2" class="{{$s->pivot->statusetapas_id == \App\StatusEtapasEnum::COMPLETA ? "has-line-through" : "" }}">{{$s->nome}}</label>
                                        </div>
                                    </div>
                                @endif
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
                        @foreach($venda->subetapas as $s)
                            @if($s->etapa_id == $e->id)
                                <div class="sub-etapa">
                                    <div class="sub-etapa-content">
                                        <input name="subetapa-3" value="{{$s->id}}" title="Conclua a etapa em andamento antes" disabled type="checkbox"><label for="subetapa-2">{{$s->nome}}</label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="medium-12 cell">
        <div class="button-group">
            <a href="{{action("VendaController@mudarStatusVenda",['id' => $venda->id, 'status' => \App\StatusVendasEnum::VENDIDO])}}" id="concluir-venda" class="button success {{$mostraBotaoDeConcluir ? "" : "disabled"}}">Concluir venda</a>
            <a href="{{action("VendaController@mudarStatusVenda",['id' => $venda->id, 'status' => \App\StatusVendasEnum::CANCELADO])}}" id="cancelar-venda" class="button alert {{$venda->status->id === \App\StatusVendasEnum::RESERVADO}}">Cancelar venda</a>
        </div>
    </div>
</div>