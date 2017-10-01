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
                    <input type="text" name="name" value="{{old('name') ?: $vendedor->name ?? ''}}">
                    @component('components.form-errors',['field' => 'name'])
                    @endcomponent
                </label>
            </div>
           
            <div class="medium-4 cell">
                <label>
                    CPF
                    <input type="text" id='cpf_cnpj' name="cpf_cnpj" value="{{old('cpf_cnpj') ?: $vendedor->cpf_cnpj ?? ''}}">
                </label>
            </div>
           
            <div class="medium-4 cell">
                <label>
                    Telefone
                    <input type="text" name="telefone" value="{{old('telefone') ?: $vendedor->telefone ?? ''}}">
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
           

         <div class="medium-4 cell form-group{{ $errors->has('password') ? ' has-error' : '' }}">
             <label>
                Password
                 <input id="password" type="password" class="form-control" name="password" required>

                 @if ($errors->has('password'))
                     <span class="help-block">
                         <strong>{{ $errors->first('password') }}</strong>
                     </span>
                 @endif
             </label>
         </div>

         <div class="medium-4 cell form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
             <label>
                Confirm Password
                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                 @if ($errors->has('password_confirmation'))
                     <span class="help-block">
                         <strong>{{ $errors->first('password_confirmation') }}</strong>
                     </span>
                 @endif
             </label>
         </div>
           
            <div class="medium-4 cell">
                <label>
                    Endereço
                    <input type="text" name="endereco" value="{{old('endereco') ?: $vendedor->endereco ?? ''}}">
                    @component('components.form-errors',['field' => 'endereco'])
                    @endcomponent
                </label>
            </div>

            @component('components.cidades',['estados' => $estados])
            @endcomponent
           
            <div class="form-group medium-4 cell">
               <label for="permissao">Permissão</label>
               <select class="form-control" name="permissao" required>
                  @if(isset($vendedor))
                  <option value="1" @if ($vendedor->permissao == 1) selected @endif>Administrador</option>
                  <option value="2" @if ($vendedor->permissao == 2) selected @endif>Vendedor</option>
                  @else
                  <option value="1">Administrador</option>
                  <option value="2" selected>Vendedor</option>
                  @endif
               </select>
            </div>

            @component('components.imobiliarias',['imobiliarias' => $imobiliarias])
            @endcomponent
           
            <div class="form-group medium-4 cell">
               <label for="ativo">Situação do usuário</label>
               <input type="hidden" name="ativo" value="0">
<!--               <input type="checkbox" name="ativo" value="1" {{old('ativo') ?: 'checked' ?? ''}}> Ativo<br>-->
               @if(isset($vendedor))
               <input type="checkbox" name="ativo" value="1" @if ($vendedor->ativo == 1) checked  @endif> Ativo<br>
               @else
               <input type="checkbox" name="ativo" value="1" checked> Ativo<br>
               @endif
            </div>

            <div class="medium-8 cell">
                <label>
                    Observações
                    <textarea name="observacoes" rows="3">{{old('observacoes') ?: $vendedor->observacoes ?? ''}}</textarea>
                </label>
            </div>
           
            <div class="medium-12 cell small-12">
                <button class="button" type="submit">Enviar</button>
            </div>
        </div>
    </form>
@endsection

@if(isset($vendedor))
   @section('footer')
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
      <script type="text/javascript">
           $(document).ready(function(){
               $("#cpf_cnpj").mask('000.000.000-00', {reverse: true});
               $("#select-estados").val({{$vendedor->cidade->estado->id}});
               $("#select-estados").trigger("change");
               $("#select-imobiliarias").val({{$vendedor->imobiliaria_id}});
               $("#select-imobiliarias").trigger("change");
               setTimeout(function(){
                   $("#select-cidades").val({{$vendedor->cidade->id}});
                   $("#select-imobiliarias").val({{$vendedor->imobiliaria_id}});
               },2000);
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