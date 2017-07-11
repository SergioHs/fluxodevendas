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
            @if(isset($cidades))
                @foreach($cidades as $c)
                    <option value="{{$c->id}}">{{$c->cidade}}</option>
                @endforeach
            @endif
        </select>
        @component('components.form-errors',['field' => 'cidade_id'])
        @endcomponent
    </label>
</div>