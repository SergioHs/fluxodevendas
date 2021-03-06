<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Empreendimento;
use App\Bloco;
use App\Utils;
use App\Estado;
use App\Cidade;
use App\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpreendimentoController extends Controller
{
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
        $empreendimentos = Empreendimento::with('cidade.estado')->orderBy('created_at','desc')->get();
        return view('empreendimentos.index',['empreendimentos' => $empreendimentos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::all();
        return view('empreendimentos.create', ['estados' => $estados]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $this->validate($r,[
            'nome' => 'required|max:255',
            'cidade_id' => 'required|numeric',
            'endereco' => 'nullable|max:255',
            'numero_blocos' => 'required|numeric',
            'nomenclatura_bloco' => 'required',
            'numero_andares' => 'required|numeric',
            'numero_ap_andares' => 'required|numeric',
            'gerenciagaragem' => 'required|numeric',
            'numero_vagas' => 'nullable|numeric'
        ]);

        try {
            DB::transaction(function () use ($r) {
                $empreendimento = new Empreendimento();
                $empreendimento->nome = $r->nome;
                $empreendimento->endereco = $r->endereco;
                $empreendimento->cidade_id = $r->cidade_id;
                $empreendimento->gerenciagaragem = $r->gerenciagaragem;
                $empreendimento->saveOrFail();
                
                for($i=1;$i<= $r->numero_vagas;$i++) {
                $vaga = new Vaga();
                $vaga->nome = $i;
                $vaga->empreendimento_id = $empreendimento->id;
                $vaga->saveOrFail();
                }

                for ($bloco = 0; $bloco < $r->numero_blocos; $bloco++) {
                    $blocoEntity = new Bloco();
                    $blocoEntity->nome = $r->nomenclatura_bloco == "algarismo" ? $bloco + 1 : Utils::alfabeto[$bloco];
                    $blocoEntity->empreendimento_id = $empreendimento->id;
                    $blocoEntity->saveOrFail();
                    $apartamentos = [];
                    for ($andar = 0; $andar < $r->numero_andares; $andar++) {
                        for ($k = 0; $k < $r->numero_ap_andares; $k++) {
                            $ap = new Apartamento();
                            $ap->bloco_id = $blocoEntity->id;
                            $ap->andar = $andar + 1;
                            $ap->numero = (int)substr_replace($r->numero_inicial_apartamentos, $andar + 1, 0, 1) + $k;

                            array_push($apartamentos, $ap);
                        }
                    }
                    $blocoEntity->apartamentos()->saveMany($apartamentos);
                }

                activity()
                    ->by(Auth::id())
                    ->on($empreendimento)
                    ->log("Cadastrou o empreendimento " . $empreendimento->nome);
            });

            $r->session()->flash('success', 'Empreendimento cadastrado com sucesso');
            return redirect()->action('EmpreendimentoController@index');
        } catch(\Exception $e) {
            $r->session()->flash('error', "Ocorreu um erro. Contate o administrador. Erro: " . $e->getMessage());
            return redirect()->action('EmpreendimentoController@create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {

        $apartamento = Apartamento::select(DB::raw("apartamentos.*, apartamentos.numero,
                                          (CASE
                                           WHEN (sum(if(vendas.statusvendas_id = 1, 1,0)) > 0)  THEN \"VENDIDO\"
                                           WHEN (sum(if(vendas.statusvendas_id = 2, 1,0)) > 0)  THEN \"RESERVADO\"
                                           ELSE \"DISPONIVEL\"
                                           END) as status"))
                                            ->join("blocos", "blocos.id", "=","apartamentos.bloco_id")
                                            ->leftJoin("vendas","apartamentos.id","=","vendas.apartamento_id")
                                            ->where('blocos.empreendimento_id','=',$id)
                                            ->groupBy('apartamentos.id')
                                            ->get();
       
//       dd($apartamento);

        $empreendimento = Empreendimento::with(['cidade.estado', 'blocos'])->findOrFail($id);

        return view('empreendimentos.detail',['empreendimento' => $empreendimento, 'apartamentos' => $apartamento]);
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
       $registro = Empreendimento::with('cidade.estado')->findOrFail($id);
       $cidades = Cidade::where("estado_id", $registro->toArray()['cidade']['estado_id'])->get();
       
       return view('empreendimentos.edit',['registro' => $registro, 'estados' => $estados, 'cidades' => $cidades]);
       
//        $estados = Estado::all();
//        return view('empreendimentos.edit', ['estados' => $estados]);
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
        $this->validate($request,[
            'nome' => 'required|max:255',
            'cidade_id' => 'required|numeric',
            'endereco' => 'nullable|max:255'
        ]);
       
       try{
            $registro = Empreendimento::findOrFail($request->id);
            activity()
                ->by(Auth::id())
                ->on($registro)
                ->log("Editou o empreendimento " . $registro->nome);
          
            $registro->nome      = $request->nome;
            $registro->endereco  = $request->endereco;
            $registro->cidade_id = $request->cidade_id;
          
            $registro->saveOrFail();

            $request->session()->flash('success', 'Empreendimento atualizado com sucesso');
            return redirect()->action('EmpreendimentoController@index');
          
       } catch(\Exception $e) {
            $request->session()->flash('error', "Ocorreu um erro. Contate o administrador. Erro: " . $e->getMessage());
            return redirect()->action('EmpreendimentoController@index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}