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
           <table class="hover" id="config-etapas">
              <thead>
                 <tr>
                    <td>Nome</td>
                    <td>Descrição</td>
                    <td>Totalizar</td>
                 </tr>
              </thead>
              <tbody>
                 @foreach($trilha->etapas as $e)
                 <tr>
                    <td>{{$e->nome}}</td>
                    <td>{{$e->descricao ?: "Não definido" }}</td>
                    <td>
                       <input type="checkbox" name="checkbox[{{$e->pivot->etapa_id}}]" 
                         @if ($e->pivot->totalizar == 1) checked @endif disabled>
                    </td>
                 </tr>
                 @endforeach
              </tbody>
           </table>
            <a href="{{action('TrilhaDeVendaController@edit',['id' => $trilha->id])}}" class="button secondary">Editar</a>
            <a href="{{action('TrilhaDeVendaController@config',['id' => $trilha->id])}}" class="button secondary">Configurar</a>
        </div>
    </div>
</div>
