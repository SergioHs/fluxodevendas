<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Estado;
use App\Cidade;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
    public function index()
    {

        $clientes = Cliente::all();
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

    public function store(Request $request)
    {
        $this->validate($request,[
            'nome' => 'required|max:255',
            'cidade_id' => 'required|numeric',
            'email' => 'nullable|email'

        ]);

        if(isset($request->id))
            $cliente = Cliente::findOrFail($request->id);
        else
            $cliente = new Cliente();

        $cliente->fill($request->all());
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