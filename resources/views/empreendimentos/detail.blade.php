<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe do empreendimento <small>{{$empreendimento->nome}}</small></h3>
                <dl>
                    <dt>Cidade</dt>
                    <dd>{{$empreendimento->cidade->cidade .  " " . $empreendimento->cidade->estado->sigla}}</dd>
                </dl>
            </div>
            <div class="medium-12 cell">
                @foreach($empreendimento->apartamentos as $a)
                    {{"Numero: " . $a->numero . " Bloco: " . $a->bloco . "Andar:" . $a->andar . "Status:"  }}<br>
                @endforeach
            </div>
        </div>
    </div>
</div>