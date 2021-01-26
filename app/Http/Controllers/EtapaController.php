<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Etapa;
use App\SubEtapa;
use Illuminate\Support\Facades\Auth;


class EtapaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $etapas = Etapa::orderBy('created_at','desc')->get();
        return view('etapas.index',['etapas' => $etapas]);
    }

    public function create()
    {
        return view('etapas.create');
    }

    public function detail($id)
    {
        $etapa = Etapa::with('subetapas')->findOrFail($id);
        return view('etapas.detail',['etapa' =>$etapa]);
    }


    public function store(Request $req)
    {
        $this->validate($req,[
            'nome' => 'required|unique:etapas,nome',
            'subetapas' => 'required',
            'prazo' => 'required'
        ]);

        $etapa = new Etapa();
        $etapa->fill($req->except('subetapas'));
        $etapa->save();

        activity()
            ->by(Auth::id())
            ->on($etapa)
            ->log("Cadastrou a etapa " . $etapa->nome);

        $subEtapas = [];

        array_map(function($arr) use (&$subEtapas, &$etapa) {
            array_push($subEtapas, new SubEtapa(['nome' => $arr, 'etapa_id' => $etapa->id]));
        },$req->subetapas);

        $etapa->subEtapas()->saveMany($subEtapas);

        $req->session()->flash('success', 'Etapa cadastrada com sucesso');
        return redirect()->action('EtapaController@index');


    }
}