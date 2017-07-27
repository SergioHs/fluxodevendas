<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Etapa;
use App\SubEtapa;


class EtapaController extends Controller
{
    public function index()
    {
        return view('etapas.index');
    }

    public function create()
    {
        return view('etapas.create');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'nome' => 'required'
        ]);
        $etapa = new Etapa();
        $etapa->nome = $req->nome;
        $etapa->prazo = $req->prazo;
        $etapa->save();

        $subEtapas = [];

        array_map(function($arr) use (&$subEtapas, &$etapa) {
            array_push($subEtapas, new SubEtapa(['nome' => $arr, 'etapa_id' => $etapa->id]));
        },$req->subetapas);

        $etapa->subEtapas()->saveMany($subEtapas);

        $req->session()->flash('success', 'Etapa cadastrada com sucesso');
        return redirect()->action('EtapaController@index');


    }
}