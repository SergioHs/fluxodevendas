<div class="medium-4 cell">
    <label>
        Imobiliaria
        <select id="select-imobiliarias" name="imobiliaria_id">
            @if(isset($imobiliarias))
                @foreach($imobiliarias as $imobiliaria)
                    <option value="{{$imobiliaria->id}}">{{$imobiliaria->nome}}</option>
                @endforeach
            @endif
        </select>
        @component('components.form-errors',['field' => 'imobiliaria_id'])
        @endcomponent
    </label>
</div>