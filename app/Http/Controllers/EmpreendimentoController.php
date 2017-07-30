<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Empreendimento;
use App\Utils;
use App\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpreendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empreendimentos = Empreendimento::with('cidade.estado')->get();
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
            'endereco' => 'nullable|max:255'
        ]);

        try {
            DB::transaction(function () use ($r) {
                $empreendimento = new Empreendimento();
                $empreendimento->nome = $r->nome;
                $empreendimento->endereco = $r->endereco;
                $empreendimento->cidade_id = $r->cidade_id;
                $empreendimento->saveOrFail();

                $apartamentos = [];

                for ($bloco = 0; $bloco < $r->numero_blocos; $bloco++) {
                    for ($andar = 0; $andar <= $r->numero_andares; $andar++) {
                        for ($k = 0; $k <= $r->numero_ap_andares; $k++) {
                            $ap = new Apartamento();
                            $ap->bloco = $r->nomenclatura_bloco == "algarismo" ? $bloco + 1 : Utils::alfabeto[$bloco];
                            $ap->andar = $andar + 1;
                            $ap->numero = (int)substr_replace($r->numero_inicial_apartamentos, $andar + 1, 0, 1) + $k;
                            $ap->empreendimento_id = $empreendimento->id;

                            array_push($apartamentos, $ap);
                        }
                    }
                }

                $empreendimento->apartamentos()->saveMany($apartamentos);
            });

            $r->session()->flash('success', 'Empreendimento cadastrado com sucesso');
            return redirect()->action('EmpreendimentoController@index');
        } catch(\Exception $e) {

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
        $empreendimento = Empreendimento::with(['cidade.estado','apartamentos.vendas.status'])->findOrFail($id);

        return view('empreendimentos.detail',['empreendimento' => $empreendimento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
