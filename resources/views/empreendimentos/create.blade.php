@extends('layouts.logged')
@section('title', 'Cadastrar Empreendimento')
@section('content')

<div class="grid-x grid-padding-y grid-padding-x">
    <div class="medium-12 cell">
        <h3>Cadastrar Empreendimento</h3>
    </div>
</div>
<form action="{{action('EmpreendimentoController@store')}}" method="POST">
    {{csrf_field()}}
    <div class="grid-x grid-padding-x">
        <div class="medium-4 cell">
            <label> Nome
                <input type="text" name="nome" required>
            </label>
            @component('components.form-errors',['field' => 'nome'])
            @endcomponent
        </div>
        <div class="medium-4 cell">
            <label> Endereço
                <input type="text" name="endereco">
            </label>
        </div>
        @component('components.cidades',['estados' => $estados, 'cidades' => $cidades ?? null])
        @endcomponent
        <div class="medium-2 cell">
            <label> Nº de blocos
                <input type="text" name="numero_blocos" required>
            </label>
            @component('components.form-errors',['field' => 'numero_blocos'])
            @endcomponent
        </div>
        <div class="medium-2 cell">
            <label> Nº de andares
                <input type="text" name="numero_andares" required>
            </label>
            @component('components.form-errors',['field' => 'numero_andares'])
            @endcomponent
        </div>
        <div class="medium-2 cell">
            <label> Nº de ap/andares
                <input type="text" name="numero_ap_andares" required>
            </label>
            @component('components.form-errors',['field' => 'numero_ap_andares'])
            @endcomponent
        </div>
        <div class="medium-2 cell">
            <label> Nº inicial apartamento
                <input type="text" name="numero_inicial_apartamentos" required>
            </label>
            @component('components.form-errors',['field' => 'numero_inicial_apartamentos'])
            @endcomponent
        </div>
        <div class="medium-3 cell">
            <label> Nomencladura de bloco
                <select name="nomenclatura_bloco">
                    <option value="alfabeto">Alfabeto</option>
                    <option value="algarismo">Algarismo</option>
                </select>
            </label>
            @component('components.form-errors',['field' => 'nomenclatura_bloco'])
            @endcomponent
        </div>
    </div>
    <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <button type="submit" class="button">Enviar</button>
        </div>
    </div>
</form>
@endsection