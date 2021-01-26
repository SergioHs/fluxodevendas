<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imobiliaria;
use App\Estado;
use App\Cidade;

class ImobiliariaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $registros = Imobiliaria::all();
//       dd($registros);
       return view('imobiliarias.index',['registros' => $registros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::all();
        return view('imobiliarias.create', ['estados' => $estados]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,['nome'=> 'required|max:255', 
                                 'cidade_id' => 'required|numeric',]);

        if(isset($request->id)){
            $registro = Imobiliaria::findOrFail($request->id);
            activity()
                ->by(Auth::id())
                ->on($registro)
                ->log("Editou a imobiliária " . $registro->nome);
        } else {
            $registro = new Imobiliaria();
            activity()
                ->by(Auth::id())
                ->on($registro)
                ->log("Cadastrou a imobiliária " . $request->nome);
        }

        $registro->fill($request->all());       
        $registro->save();

        $request->session()->flash('success', 'Imobiliária cadastrada com sucesso');

        return redirect()->action('ImobiliariaController@index');
//        return redirect()->route('imobiliarias.index');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registro = Imobiliaria::with('cidade')->findOrFail($id);
        return view('imobiliarias.detail',['registro' => $registro]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $estados = Estado::all();
       $registro = Imobiliaria::with('cidade.estado')->findOrFail($id);
       $cidades = Cidade::where("estado_id", $registro->toArray()['cidade']['estado_id'])->get();
       
       return view('imobiliarias.create',['registro' => $registro, 'estados' => $estados, 'cidades' => $cidades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request,['nome'=> 'required',]);
       
       $registro = Imobiliaria::findOrFail($id);
       
       $registro->nome = $request->nome;
       $registro->save();
       
       return redirect()->route('imobiliarias.index')->with('alert-success','Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $registro = Imobiliaria::findOrFail($id);
       
       if ($registro->vendedores()->count() > 0){
          return redirect()->route('imobiliaria.index')->with('alert-success','O registro não pode ser excluído, pois possui vendedores cadastrados');
       } else{
          $registro->delete();
          return redirect()->route('imobiliarias.index')->with('alert-success','Registro excluído com sucesso!');
       }
    }
}