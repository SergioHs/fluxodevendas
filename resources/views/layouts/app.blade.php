<html>
<head>
    <title>Fluxo de vendas - @yield('title')</title>
    <meta name="viewport" content="width=device-width">
    <link href="<?=asset('/css/app.css')?>" rel="stylesheet">
    <link href="<?=asset('/css/custom.css')?>" rel="stylesheet">
</head>

<body>

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