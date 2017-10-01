@extends('layouts.logged')
@section('title', 'Cadastro de Cliente')
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
            <input type="text" id='cpf_cnpj' name="cpf_cnpj" value="{{old('cpf_cnpj') ?: $cliente->cpf_cnpj ?? ''}}">
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

@if(isset($cliente))
@section('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
            $("#cpf_cnpj").mask('000.000.000-00', {reverse: true});
            $("#select-estados").val({{$cliente->cidade->estado->id}});
            $("#select-estados").trigger("change");
            setTimeout(function(){
                $("#select-cidades").val({{$cliente->cidade->id}});
            },4000);
        });
</script>
@endsection
@else
@section('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
<script type="text/javascript">
   $(document).ready(function () { 
        $("#cpf_cnpj").mask('000.000.000-00', {reverse: true});
    });
</script>
@endsection
@endif
