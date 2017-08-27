@extends('layouts.logged')
@section('title', 'Clientes')
@section('content')
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="auto cell">
            <h3 style="display: inline;">Log de atividade</h3>
        </div>
        <div class="auto cell">

        </div>
    </div>
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="medium-12 cell">
            @if(count($logs) > 0)
                <table>
                    <thead>
                    <tr>
                        <td>Descrição</td>
                        <td>Usuario</td>
                        <td>Data</td>
                    </tr>
                    </thead>
                    <tbody >
                    @foreach($logs as $l)
                        <tr>
                            <td>{{$l->description}}</td>
                            <td>{{$l->causer->name}}</td>
                            <td>{{date('d/m/Y',strtotime($l->created_at))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$logs->links()}}
            @else
                @component('components.nenhum-resultado')
                @endcomponent
            @endif
        </div>
    </div>
@endsection
