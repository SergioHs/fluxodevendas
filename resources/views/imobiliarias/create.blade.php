@extends('layouts.logged')
@section('title', 'Cadastro de Imobiliária')
@section('content')
<div class="grid-x grid-padding-x">
    <div class="medium-12 cell">
        <h3>{{isset($registro) ? 'Editar' : 'Cadastrar'}} Imobiliária</h3>
    </div>
</div>
<form method="post" action="{{url('/imobiliaria/store')}}">
   {{ csrf_field() }}
   @if(isset($registro))
   <input name="id" value="{{$registro->id}}" type="hidden">
   @endif
   <div class="grid-x grid-padding-x">
       <div class="medium-4 cell">
           <label>
               Nome
               <input type="text" name="nome" value="{{old('nome') ?: $registro->nome ?? ''}}">
               @component('components.form-errors',['field' => 'nome'])
               @endcomponent
           </label>
      </div>
           
      <div class="medium-4 cell">
          <label>
              Telefone
              <input type="text" name="telefone" value="{{old('telefone') ?: $registro->telefone ?? ''}}">
          </label>
      </div>

      <div class="medium-4 cell">
          <label>
              Email
              <input type="text" name="email" value="{{old('email') ?: $registro->email ?? ''}}">
              @component('components.form-errors',['field' => 'email'])
              @endcomponent
          </label>
      </div>

      <div class="medium-4 cell">
          <label>
              Endereço
              <input type="text" name="endereco" value="{{old('endereco') ?: $registro->endereco ?? ''}}">
              @component('components.form-errors',['field' => 'endereco'])
              @endcomponent
          </label>
      </div>

      @component('components.cidades',['estados' => $estados])
      @endcomponent
   
    <div class="medium-12 cell small-12">
        <button class="button" type="submit">Enviar</button>
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