<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Estado;
use App\Cidade;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use Illuminate\Support\Facades\Auth;


class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
       if (Auth::user()->permissao == 1){
          $clientes = Cliente::all();
       }
       else{
          $clientes = Cliente::where('user_id', '=', Auth::user()->id)->get();
       }
       
       return view('clientes.index',['clientes' => $clientes]);
    }

    public function create()
    {
        $estados = Estado::all();
        return view('clientes.create', ['estados' => $estados]);
    }

    public function edit($id)
    {
        $estados = Estado::all();
        $cliente = Cliente::with('cidade.estado')->findOrFail($id);
        $cidades = Cidade::where("estado_id", $cliente->toArray()['cidade']['estado_id'])->get();

        return view('clientes.create', ['cliente' => $cliente, 'estados' => $estados, 'cidades' => $cidades]);
    }

    public function store(ClienteRequest $request)
    {
        if(isset($request->id)){
            $cliente = Cliente::findOrFail($request->id);
            activity()
                ->by(Auth::id())
                ->on($cliente)
                ->log("Editou cliente " . $cliente->nome);
        } else {
            $cliente = new Cliente();
            activity()
                ->by(Auth::id())
                ->on($cliente)
                ->log("Cadastrou cliente " . $request->nome);
        }

        $cliente->fill($request->all());
        $cliente->user_id = Auth::user()->id;
        $cliente->save();

        $request->session()->flash('success', 'Cliente cadastrado com sucesso');



        return redirect()->action('ClienteController@index');
    }

    public function detail($id)
    {
        $cliente = Cliente::with('cidade')->findOrFail($id);
        return view('clientes.detail',['cliente' => $cliente]);
    }
}