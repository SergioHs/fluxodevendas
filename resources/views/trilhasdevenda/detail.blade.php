<div class="grid-x grid-padding-x">
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <h3> Detalhe da trilha <small>{{$trilha->nome}}</small></h3>
            </div>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Nome</dt>
                <dd>{{$trilha->nome ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-6 cell">
            <dl>
                <dt>Descrição</dt>
                <dd>{{$trilha->descricao ?: "Não definido"}}</dd>
            </dl>
        </div>
        <div class="medium-12 cell">
            <dl>
                <dt>Observações</dt>
                <dd>{{$trilha->observacoes ?: "Não Definido"}}</dd>
            </dl>
        </div>
        <div class="medium-12 cell">
            <p class="lead">Etapas</p>
            @component('components.etapas',['etapas' => $trilha->etapas])
            @endcomponent
            <a href="{{action('TrilhaDeVendaController@edit',['id' => $trilha->id])}}" class="button secondary">Editar</a>
        </div>
    </div>
</div>
