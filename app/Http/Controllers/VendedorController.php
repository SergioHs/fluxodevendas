<?php

namespace App\Http\Controllers;

use App\Vendedor;
use App\User;
use App\Estado;
use App\Cidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $vendedores = Vendedor::all();
        $vendedores = User::all();
        return view('vendedores.index',['vendedores' => $vendedores]);
    }

    public function create()
    {
        $estados = Estado::all();
        return view('vendedores.create', ['estados' => $estados]);
    }

    public function edit($id)
    {
        $estados = Estado::all();
//        $vendedor = Vendedor::with('cidade.estado')->findOrFail($id);
        $vendedor = User::with('cidade.estado')->findOrFail($id);
        $cidades = Cidade::where("estado_id", $vendedor->toArray()['cidade']['estado_id'])->get();
       
//       dd($vendedor);

        return view('vendedores.create', ['vendedor' => $vendedor, 'estados' => $estados, 'cidades' => $cidades]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:255',
            'cidade_id' => 'required|numeric',
            'email' => 'nullable|email',
            'password' => 'required|string|min:6|confirmed'
        ]);
       
//       dd($request);

        if(isset($request->id)){
//            $vendedor = Vendedor::findOrFail($request->id);
            $vendedor = User::findOrFail($request->id);
            activity()
                ->by(Auth::id())
                ->on($vendedor)
                ->log("Editou o vendedor " . $vendedor->name);
        } else {
//            $vendedor = new Vendedor();
            $vendedor = new User();
            activity()
                ->by(Auth::id())
                ->on($vendedor)
                ->log("Cadastrou o vendedor " . $request->name);
        }

        $vendedor->fill($request->all());
        $vendedor->password = bcrypt($request->password);
       
//       dd($request);
       
        $vendedor->save();

        $request->session()->flash('success', 'Vendedor cadastrado com sucesso');

        return redirect()->action('VendedorController@index');
    }

    public function detail($id)
    {
//        $vendedor = Vendedor::with('cidade')->findOrFail($id);
        $vendedor = User::with('cidade')->findOrFail($id);
        return view('vendedores.detail',['vendedor' => $vendedor]);
    }
}