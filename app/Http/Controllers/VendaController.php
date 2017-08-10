<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Cliente;
use App\Empreendimento;
use App\Events\VendaCadastrada;
use App\StatusEtapasEnum;
use App\TrilhaDeVendas;
use App\Venda;
use App\Vendedor;
use Illuminate\Http\Request;
use App\StatusVendasEnum;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with(['apartamento.empreendimento','vendedor', 'cliente', 'status'])->get();
        return view('vendas.index',['vendas' => $vendas]);
    }

    public function detail($id)
    {
        $venda = Venda::with(['apartamento.empreendimento','vendedor', 'cliente', 'status', 'trilhaDeVenda','etapas','subetapas'])->findOrFail($id);
        //var_dump($venda->subEtapas->toArray());die;


        $etapasConcluidas = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::COMPLETA;
        });

        $etapaEmAndamento = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ADANTAMENTO;
        });

        $etapasEmEspera = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ESPERA;
        });

        //$todasEtapasDaVenda

        return view('vendas.detail',
            [
            'venda' => $venda,
            'etapasConcluidas' => $etapasConcluidas,
            'etapaEmAndamento' => $etapaEmAndamento,
            'etapasEmEspera' => $etapasEmEspera
            ]
        );
    }

    public function create(Request $r)
    {
        if ($r->query('apartamento')) {
            $apartamento = Apartamento::with('empreendimento')->findOrFail($r->query('apartamento'));
        }

        if ($r->query('cliente')) {
            $cliente = Cliente::findOrFail($r->query('cliente'));
        }

        $vendedores = Vendedor::get();
        $clientes = Cliente::get();
        $trilhas = TrilhaDeVendas::get();
        $empreendimentos = Empreendimento::get();

        return view('vendas.create', ['vendedores' => $vendedores, 'clientes' => $clientes, 'apartamento' => $apartamento, 'trilhas' => $trilhas, 'empreendimentos' => $empreendimentos, 'cliente' => isset($cliente) ? $cliente : null]);
    }

    public function store(Request $r)
    {
        $venda = new Venda();
        $venda->fill($r->all());
        $venda->statusvendas_id = StatusVendasEnum::RESERVADO;
        $venda->save();
        event(new VendaCadastrada($venda));

        $r->session()->flash('success', 'Venda iniciada com sucesso');
        return redirect()->action('VendaController@index');

    }

    public function concluirEtapaEmAndamento($id)
    {
        $venda = Venda::with('etapas')->findOrFail($id);
        $etapaEmAndamento = $venda->etapas->filter(function($v,$k){
           return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ADANTAMENTO;
        })->first();

        $proximaEtapaEmEspera = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ESPERA;
        })->first();

        $venda->etapas()->updateExistingPivot($etapaEmAndamento->id, ['statusetapas_id' => StatusEtapasEnum::COMPLETA]);
        $venda->etapas()->updateExistingPivot($proximaEtapaEmEspera->id, ['statusetapas_id' => StatusEtapasEnum::EM_ADANTAMENTO]);
    }

    public function mudarStatusSubEtapa($vendaId, $subEtapaid)
    {
        $venda = Venda::with('subetapas')->findOrFail($vendaId);

        $statusAntigo = \DB::table('vendas')
                ->join('vendas_subetapas','vendas.id','=','vendas_subetapas.venda_id')
                ->where([['vendas.id','=',$vendaId],['vendas_subetapas.subetapa_id','=',$subEtapaid]])
                ->select('vendas_subetapas.statusetapas_id')
                ->first()->statusetapas_id;

        $statusNovo = in_array($statusAntigo,[StatusEtapasEnum::EM_ADANTAMENTO, StatusEtapasEnum::EM_ESPERA]) ? StatusEtapasEnum::COMPLETA : StatusEtapasEnum::EM_ADANTAMENTO;

        $venda->subEtapas()->updateExistingPivot($subEtapaid, ['statusetapas_id' => $statusNovo]);
    }


}