<div class="medium-4 cell">
    <label>
        Estado
        <select id="select-estados">
            @foreach($estados as $e)
                <option value="{{$e->id}}">{{$e->sigla}}</option>
            @endforeach
        </select>
    </label>
</div>
<div class="medium-4 cell">
    <label>
        Cidade
        <select id="select-cidades" name="cidade_id">
        </select>
    </label>
</div>