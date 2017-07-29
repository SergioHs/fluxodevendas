<table class="hover" id="etapas-table">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Descrição</td>
        </tr>
    </thead>
    <tbody>
        @foreach($etapas as $e)
            <tr data-toggle="subetapas-{{$e->id}}">
                <td>{{$e->nome}}</td>
                <td>{{$e->descricao ?: "Não definido" }}</td>
            </tr>
            <div class="hidden" id="subetapas-{{$e->id}}">
                @foreach($e->subEtapas as $s)
                    {{$s->nome}}
                @endforeach
            </div>
        @endforeach
    </tbody>
</table>

