<?php

namespace App\Http\Controllers;
use App\Etapa;
use App\TrilhaDeVendas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TrilhaDeVendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $trilhas = TrilhaDeVendas::orderBy('created_at','desc')->get();
        return view('trilhasdevenda.index', ['trilhas' => $trilhas]);
    }

    public function create()
    {
        $etapas = Etapa::all();
       
        //variável de controle para a mensagem que alerta quando não existem etapas cadastradas
        //não é possível duas condições no if de um arquivo Blade (etapas->count() ==0 && isset(trilha))
        $cadastrarEtapas = 0;
        if($etapas->count() == 0){
           $cadastrarEtapas = 1;
        }
       
        return view('trilhasdevenda.create', 
                    ['etapas' => $etapas, 'cadastrarEtapas' => $cadastrarEtapas]);
    }

    public function edit($id)
    {
        $trilha = TrilhaDeVendas::with(['etapas.subetapas','vendas'])->findOrFail($id);
        $trilha->etapas = $trilha->etapas->sortBy(function($etapa,$key){
            return $etapa->pivot->ordem;
        });
       
//       dd($trilha);

        if(count($trilha->vendas) > 0){
            Session::flash('error', 'Não é possível editar uma trilha que uma venda já esteja participando');
            return redirect()->action('TrilhaDeVendaController@index');
        }

        $etapasJaCadastradas = [];
        foreach($trilha->etapas as $e)
            array_push($etapasJaCadastradas, $e->id);

        $etapas = Etapa::whereNotIn('id',$etapasJaCadastradas)->get();
       
        $cadastrarEtapas = 0;
       
//       dd($cadastrarEtapas);

        return view('trilhasdevenda.create',
                    ['etapas' => $etapas, 
                     'trilha' => $trilha, 
                     'cadastrarEtapas' => $cadastrarEtapas]);
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'nome' => 'required|max:255',
            'descricao' => 'max:255',
            'observacoes' => 'max:255',
            'etapas' => 'required'
        ]);

        if(isset($request->id)){
            $trilha = TrilhaDeVendas::findOrFail($request->id);
            activity()
                ->by(Auth::id())
                ->on($trilha)
                ->log("Editou a trilha de vendas " . $trilha->nome);
        } else {
            $trilha = new TrilhaDeVendas();
            activity()
                ->by(Auth::id())
                ->on($trilha)
                ->log("Cadastrou a trilha de vendas " . $request->nome);
        }

        $trilha->nome = $request->nome;
        $trilha->descricao = $request->descricao;
        $trilha->observacoes = $request->observacoes;
        $trilha->ativo = $request->ativo;
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
        $trilha->etapas = $trilha->etapas->sortBy(function($etapa,$key){
            return $etapa->pivot->ordem;
        });
        return view('trilhasdevenda.detail',['trilha' => $trilha]);
    }
}