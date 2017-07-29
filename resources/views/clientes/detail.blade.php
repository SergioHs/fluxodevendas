<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe do cliente <small>{{$cliente->nome}}</small></h3>
            </div>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>CPF/CNPJ</dt>
                <dd>{{$cliente->cpf_cnpj ?: "Não definido"}}</dd>
                <dt>Email</dt>
                <dd>{{$cliente->email ?: "Não definido"}}</dd>
                <dt>Telefone</dt>
                <dd>{{$cliente->telefone ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Endereço</dt>
                <dd>{{$cliente->endereco ?: "Não definido"}}</dd>
                <dt>Cidade</dt>
                <dd>{{$cliente->cidade->cidade ?: "Não definido"}}</dd>
                <dt>Estado</dt>
                <dd>{{$cliente->cidade->estado->sigla ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-12 cell">
            <dl>
                <dt>Observações</dt>
                <dd>{{$cliente->observacoes ?: ""}}</dd>
            </dl>
        </div>
        <div class="medium-12 cell">
            <a href="{{action('TrilhaDeVendaController@create',['id' => $cliente->id])}}" class="button secondary">Editar</a>
        </div>
    </div>
</div>
