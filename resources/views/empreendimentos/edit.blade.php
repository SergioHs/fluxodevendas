@extends('layouts.logged')
@section('title', 'Cadastrar Empreendimento')
@section('content')

<div class="grid-x grid-padding-y grid-padding-x">
    <div class="medium-12 cell">
        <h3>Editar Empreendimento</h3>
    </div>
</div>
<form action="{{action('EmpreendimentoController@update',$registro->id)}}" method="POST">
    {{csrf_field()}}
   <input name="id" value="{{$registro->id}}" type="hidden">
    <div class="grid-x grid-padding-x">
        <div class="medium-4 cell">
            <label> Nome
                <input type="text" name="nome" value="{{$registro->nome}}" required>
            </label>
            @component('components.form-errors',['field' => 'nome'])
            @endcomponent
        </div>
        <div class="medium-8 cell">
            <label> Endereço
                <input type="text" name="endereco" value="{{$registro->endereco}}">
            </label>
        </div>
        @component('components.cidades',['estados' => $estados, 'cidades' => $cidades ?? null])
        @endcomponent
    </div>
    <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <button type="submit" class="button">Enviar</button>
        </div>
    </div>
</form>
@endsection

@isset($registro)
@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#select-estados").val({{$registro->cidade->estado->id}});
            $("#select-estados").trigger("change");
            setTimeout(function(){
                $("#select-cidades").val({{$registro->cidade->id}});
            },4000);
        });
    </script>
@endsection
@endisset