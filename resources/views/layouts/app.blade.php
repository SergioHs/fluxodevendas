<html>
<head>
    <title>Fluxo de vendas - @yield('title')</title>
    <link href="<?=asset('/css/app.css')?>" rel="stylesheet">
    <link href="<?=asset('/css/custom.css')?>" rel="stylesheet">
</head>

<body>

{{--<div class="title-bar" data-responsive-toggle="responsive-top-bar" data-hide-for="medium">--}}
{{--<button class="menu-icon" type="button" data-toggle="responsive-top-bar"></button>--}}
{{--<div class="title-bar-title">Fluxo de vendas</div>--}}
{{--</div>--}}

{{--<div class="top-bar" id="responsive-top-bar">--}}
{{--<div class="top-bar-left">--}}

{{--<ul class="menu align-left">--}}
{{--<li class="menu-text hide-for-small-only"> Fluxo de Vendas</li>--}}

{{--<li><a href="#">Pendências</a></li>--}}
{{--<li><a href="#">Empreendimentos</a></li>--}}
{{--<li><a href="#">Pessoas</a></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div class="top-bar-right">--}}
{{--<ul class="menu align-right">--}}
{{--<li><a href="#">Minha conta</a></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
@section('topbar')
<div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="example-menu">
    <div class="top-bar-right">
        <ul class="menu">
            <li class="menu-text">Vendas</li>
        </ul>
    </div>
    <div class="top-bar-left">
        <ul class=" medium-horizontal vertical dropdown menu" data-responsive-menu="accordion medium-dropdown">
            <li class="has-submenu ">
                <a href="#">Pessoas</a>
                <ul class="submenu menu vertical nested " data-submenu>
                    <li><a href="#">Clientes</a></li>
                    <li><a href="#">Vendedores</a></li>
                </ul>
            </li>
            <li class="has-submenu ">
                <a href="#">Trilhas de venda</a>
                <ul class="submenu menu vertical nested " data-submenu>
                    <li><a href="#">Trilhas</a></li>
                    <li><a href="#">Etapas</a></li>
                    <li><a href="#">Sub-Etapas</a></li>
                </ul>
            </li>
            <li><a href="#">Empreendimentos</a></li>
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

@yield('content')

<script src="<?=asset('/js/app.js')?>"></script>
<script> $(document).foundation();</script>
</body>
</html>