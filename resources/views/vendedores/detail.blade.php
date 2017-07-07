<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe do vendedor <small>{{$vendedor->nome}}</small></h3>
            </div>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>CPF/CNPJ</dt>
                <dd>{{$vendedor->cpf_cnpj ?: "Não definido"}}</dd>
                <dt>Email</dt>
                <dd>{{$vendedor->email ?: "Não definido"}}</dd>
                <dt>Telefone</dt>
                <dd>{{$vendedor->telefone ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Endereço</dt>
                <dd>{{$vendedor->endereco ?: "Não definido"}}</dd>
                <dt>Cidade</dt>
                <dd>{{$vendedor->cidade->cidade ?: "Não definido"}}</dd>
                <dt>Estado</dt>
                <dd>{{$vendedor->cidade->estado->sigla ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-12 cell">
            <dt>Observações</dt>
            <dd>{{$vendedor->observacoes ?: ""}}</dd>
        </div>
    </div>
</div>
