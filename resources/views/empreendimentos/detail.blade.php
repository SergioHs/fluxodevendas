<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe do empreendimento <small>{{$empreendimento->nome}}</small></h3>
                <dl>
                    <dt> Endereço </dt>
                    <dd> {{$empreendimento->endereco ?: "Não informado" }}</dd>
                    <dt>Cidade</dt>
                    <dd>{{$empreendimento->cidade->cidade .  " " . $empreendimento->cidade->estado->sigla}}</dd>
                </dl>
            </div>
            @if(count($apartamentos) > 0)
            <div class="medium-12 cell">
                <p class="lead">Apartamentos</p>
                @foreach($apartamentos as $a)
                    <a @if($a->status == "DISPONIVEL") href={{action("VendaController@create",['apartamento' => $a->id, 'cliente' => null])}} @endif data-open="modal-venda" class="button small {{$a->status == "VENDIDO" ? "alert disabled" : ($a->status == "RESERVADO" ? "warning disabled " : "success")}}">
                        <strong>Numero:</strong> {{ $a->numero }} <strong>Bloco: </strong> {{ $a->bloco }} <strong> Andar:</strong> {{$a->andar }}
                    </a>
                @endforeach
            </div>

            @endif
        </div>
    </div>
</div>