@extends('layouts.app')
@section('title', 'Cadastrar Cliente')
@section('content')
<div class="grid-x grid-padding-x">
    <div class="medium-12 cell">
        <h3>{{isset($cliente) ? 'Editar' : 'Cadastrar'}} Cliente</h3>
    </div>
</div>
<form method="post" action="{{url('/cliente/store')}}">
{{ csrf_field() }}
@if(isset($cliente))
<input name="id" value="{{$cliente->id}}" type="hidden">
@endif
<div class="grid-x grid-padding-x">
    <div class="medium-4 cell">
        <label>
            Nome
            <input type="text" name="nome" value="{{old('nome') ?: $cliente->nome ?? ''}}">
            @component('components.form-errors',['field' => 'nome'])
            @endcomponent
        </label>
    </div>
    <div class="medium-4 cell">
        <label>
            CPF
            <input type="text" name="cpf_cnpj" value="{{old('cpf_cnpj') ?: $cliente->cpf_cnpj ?? ''}}">
        </label>
    </div>
    <div class="medium-4 cell">
        <label>
            Email
            <input type="text" name="email" value="{{old('email') ?: $cliente->email ?? ''}}">
            @component('components.form-errors',['field' => 'email'])
            @endcomponent
        </label>
    </div>
    <div class="medium-4 cell">
        <label>
            Telefone
            <input type="text" name="telefone" value="{{old('telefone') ?: $cliente->telefone ?? ''}}">
        </label>
    </div>

    @component('components.cidades',['estados' => $estados, 'cidades' => $cidades ?? null])
    @endcomponent

    <div class="medium-8 cell">
        <label>
            Observações
            <textarea name="observacoes" rows="3">{{old('observacoes') ?: $cliente->observacoes ?? ''}}</textarea>
        </label>
    </div>
    <div class="medium-12 cell small-12">
        <button class="button" type="submit">Enviar</button>
    </div>
</div>
</form>
@endsection

@isset($cliente)
@section('footer')
<script type="text/javascript">
        $(document).ready(function(){
            $("#select-estados").val({{$cliente->cidade->estado->id}});
            $("#select-cidades").val({{$cliente->cidade->id}});
        });
</script>
@endsection
@endisset