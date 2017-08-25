@extends('layouts.logged')
@section('title', 'Cadastro de Vendedor')
@section('content')
    <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <h3>{{isset($vendedor) ? 'Editar' : 'Cadastrar'}} Vendedor</h3>
        </div>
    </div>
    <form method="post" action="{{action('VendedorController@store')}}">
        {{ csrf_field() }}
        @if(isset($vendedor))
            <input name="id" value="{{$vendedor->id}}" type="hidden">
        @endif
        <div class="grid-x grid-padding-x">
            <div class="medium-4 cell">
                <label>
                    Nome
                    <input type="text" name="nome" value="{{old('nome') ?: $vendedor->nome ?? ''}}">
                    @component('components.form-errors',['field' => 'nome'])
                    @endcomponent
                </label>
            </div>
            <div class="medium-4 cell">
                <label>
                    CPF
                    <input type="text" name="cpf_cnpj" value="{{old('cpf_cnpj') ?: $vendedor->cpf_cnpj ?? ''}}">
                </label>
            </div>
            <div class="medium-4 cell">
                <label>
                    Email
                    <input type="text" name="email" value="{{old('email') ?: $vendedor->email ?? ''}}">
                    @component('components.form-errors',['field' => 'email'])
                    @endcomponent
                </label>
            </div>
            <div class="medium-4 cell">
                <label>
                    Telefone
                    <input type="text" name="telefone" value="{{old('telefone') ?: $vendedor->telefone ?? ''}}">
                </label>
            </div>

            @component('components.cidades',['estados' => $estados])
            @endcomponent

            <div class="medium-8 cell">
                <label>
                    Observações
                    <textarea name="observacoes" rows="3" value="{{old('observacoes') ?: $vendedor->observacoes ?? ''}}"></textarea>
                </label>
            </div>
            <div class="medium-12 cell small-12">
                <button class="button" type="submit">Enviar</button>
            </div>
        </div>
    </form>
@endsection

@isset($vendedor)
@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#select-estados").val({{$vendedor->cidade->estado->id}});
            $("#select-estados").trigger("change");
            setTimeout(function(){
                $("#select-cidades").val({{$vendedor->cidade->id}});
            },4000);

        });
    </script>
@endsection
@endisset