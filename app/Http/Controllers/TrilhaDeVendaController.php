<?php

namespace App\Http\Controllers;
use App\Etapa;
use App\TrilhaDeVendas;
use Illuminate\Http\Request;

class TrilhaDeVendaController extends Controller
{
    public function index()
    {
        $trilhas = TrilhaDeVendas::all();
        return view('trilhasdevenda.index', ['trilhas' => $trilhas]);
    }

    public function create()
    {
        $etapas = Etapa::all();
        return view('trilhasdevenda.create', ['etapas' => $etapas]);
    }

    public function edit($id)
    {
        return view('trilhadevenda.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'nome' => 'required|max:255',
            'descricao' => 'max:255',
            'observacoes' => 'max:255',
            'etapas' => 'required'
        ]);

        $trilha = new TrilhaDeVendas();
        $trilha->nome = $request->nome;
        $trilha->descricao = $request->descricao;
        $trilha->observacoes = $request->observacoes;
        $trilha->save();

        $i = 1;
        $etapas = [];
        foreach($request->etapas as $e){
            $etapas[$e] = ['ordem' => $i];
            $i++;
        }
        $trilha->etapas()->sync($etapas);

        $request->session()->flash('success', 'Trilha de venda cadastrada com sucesso');
        return redirect()->action('TrilhaDeVendaController@index');
    }

    public function detail($id)
    {
        $trilha = TrilhaDeVendas::with('etapas.subetapas')->findOrFail($id);
        return view('trilhasdevenda.detail',['trilha' => $trilha]);
    }
}