<html>
<head>
    <title>Fluxo de vendas - @yield('title')</title>
    <meta name="viewport" content="width=device-width">
    <link href="<?=asset('/css/app.css')?>" rel="stylesheet">
    <link href="<?=asset('/css/custom.css')?>" rel="stylesheet">
</head>

<body>

@section('topbar')
<div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="example-menu">
    <div class="top-bar-right">
        <ul class="menu">
            <li class="menu-text">Controle de Vendas</li>
        </ul>
    </div>
    <div class="top-bar-left">
        <ul class=" medium-horizontal vertical dropdown menu" data-responsive-menu="accordion medium-dropdown">
            <li><a href="{{action("VendaController@pendencies")}}">Pendências</a></li>
            <li class="has-submenu ">
               @if (Auth::user()->permissao == 1)
                <a href="#">Cadastros</a>
                <ul class="submenu menu vertical nested " data-submenu>
                    <li><a href="{{action("ClienteController@index")}}" title="Listar clientes">Clientes</a></li>
                    <li><a href="{{action("VendedorController@index")}}" title="Listar vendedores">Vendedores</a></li>
                    <li><a href="{{action("ImobiliariaController@index")}}" title="Listar imobiliárias">Imobiliárias</a></li>
                </ul>
               @else
               <li><a href="{{action("ClienteController@index")}}" title="Listar clientes">Clientes</a></li>
               @endif
            </li>
            @if (Auth::user()->permissao == 1)
            <li class="has-submenu ">
                <a href="#">Trilhas de venda</a>
                <ul class="submenu menu vertical nested " data-submenu>
                    <li><a href="{{action("TrilhaDeVendaController@index")}}" title="Listar trilhas de vendas">Trilhas</a></li>
                    <li><a href="{{action("EtapaController@index")}}" title="Listar etapas">Etapas</a></li>
                </ul>
            </li>
            @endif
            <li><a href="{{action("EmpreendimentoController@index")}}" title="Listar empreendimentos">Empreendimentos</a></li>
            <li><a href="{{action("VendaController@index")}}" title="Listar vendas">Vendas</a></li>
        </ul>
    </div>
    <div class="top-bar-right">
        <ul class=" medium-horizontal vertical dropdown menu" data-responsive-menu="accordion medium-dropdown">
        <li class="has-submenu ">
            <a href="#">{{Auth::user()->name}}</a>
            <ul class="submenu menu vertical nested " data-submenu>
                {{--<li disabled><a>Redefinir senha</a></li>--}}
                @if (Auth::user()->permissao == 1)
                  <li><a href="{{url("/logs")}}">Logs</a></li>
                @endif
                <li><a href="{{url("/logout")}}">Sair</a></li>
            </ul>
        </li>
        </ul>
    </div>
</div>
@show

@section('flash-message')
    @if(Session::has("flash-error"))
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <div class="alert callout small">
                    {{Session::get("flash")}}
                </div>
            </div>
        </div>

    @endif
@show

@component('components.flash-message')
@endcomponent

<div class="grid-container">
    @yield('content')
</div>

<script src="<?=asset('/js/app.js')?>"></script>
<script> $(document).foundation();</script>

@yield('footer')

</body>
</html>