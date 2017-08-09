<table class="hover" id="etapas-table">
    <thead>
        <tr>
            <td>Nome</td>
            <td>Descrição</td>
        </tr>
    </thead>
    <tbody>
        @foreach($etapas as $e)
            <tr>
                <td>{{$e->nome}}</td>
                <td>{{$e->descricao ?: "Não definido" }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

