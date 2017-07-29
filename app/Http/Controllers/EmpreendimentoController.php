<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Empreendimento;
use App\Estado;
use Illuminate\Http\Request;

class EmpreendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('empreendimentos.index',['empreeendimentos' => Empreendimento::all()]);
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
        $empreendimento = new Empreendimento();
        $empreendimento->nome = $r->nome;
        $empreendimento->endereco = $r->endereco;
        $empreendimento->cidade_id = $r->cidade_id;
        $empreendimento->saveOrFail();

        $apartamentos = [];

        for($i = 0; $i <= $r->numero_blocos; $i++){
            for($j = 0; $j <= $r->numero_andares; $j++){
                for($k =0; $k <= $r->numero_ap_andares; $k++){
                    $ap = new Apartamento();
                    $ap->bloco = $i+1;
                    $ap->andar = $j+1;
                    $ap->numero = (int)substr_replace($r->numero_inicial_apartamentos,$j+1,0,1) + $k;
                    $ap->empreendimento_id = $empreendimento->id;

                    array_push($apartamentos,$ap);

                }
            }
        }

        $empreendimento->apartamentos()->saveMany($apartamentos);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        //
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
