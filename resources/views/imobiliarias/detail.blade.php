<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe da imobiliária <small>{{$registro->nome}}</small></h3>
            </div>
        </div>
       <div class="medium-12 cell">
            <dl>
                <dt>Endereço</dt>
                <dd>{{$registro->endereco ?: "Não definido"}}</dd>
          </dl>
       </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Email</dt>
                <dd>{{$registro->email ?: "Não definido"}}</dd>
                <dt>Telefone</dt>
                <dd>{{$registro->telefone ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Cidade</dt>
                <dd>{{$registro->cidade->cidade ?: "Não definido"}}</dd>
                <dt>Estado</dt>
                <dd>{{$registro->cidade->estado->sigla ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-12 cell">
            <a href="{{action('ImobiliariaController@edit',['id' => $registro->id])}}" class="button secondary">Editar</a>
        </div>
    </div>
</div>
