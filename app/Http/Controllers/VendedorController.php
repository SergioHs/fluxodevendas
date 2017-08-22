<?php

namespace App\Http\Controllers;

use App\Vendedor;
use App\Estado;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendedores = Vendedor::all();
        return view('vendedores.index',['vendedores' => $vendedores]);
    }

    public function create()
    {
        $estados = Estado::all();
        return view('vendedores.create', ['estados' => $estados]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nome' => 'required|max:255',
            'cidade_id' => 'required|numeric',
            'email' => 'nullable|email'

        ]);

        $vendedor = new Vendedor();
        $vendedor->fill($request->all());
        $vendedor->save();

        $request->session()->flash('success', 'vendedor cadastrado com sucesso');

        return redirect()->action('VendedorController@index');
    }

    public function detail($id)
    {
        $vendedor = Vendedor::with('cidade')->findOrFail($id);
        return view('vendedores.detail',['vendedor' => $vendedor]);
    }

}