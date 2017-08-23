<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Cliente;
use App\DataService;
use App\Empreendimento;
use App\Events\VendaCadastrada;
use App\StatusEtapasEnum;
use App\TrilhaDeVendas;
use App\Venda;
use App\Vendedor;
use Illuminate\Http\Request;
use App\StatusVendasEnum;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $vendedores = Vendedor::all();
        $clientes = Cliente::all();
        $empreendimentos = Empreendimento::all();

        $vendas = Venda::with(['apartamento.bloco.empreendimento','vendedor', 'cliente', 'status']);

        if($request->isMethod('post'))
        {
            if($request->has('vendedor_id'))
                $vendas->where('vendedor_id','=',$request->vendedor_id);

            if($request->has('cliente_id'))
                $vendas->where('cliente_id','=',$request->cliente_id);

            if(isset($request->empreendimento_id))
                $vendas->whereHas('apartamento.bloco',function($q) use ($request){
                    $q->where('empreendimento_id','=',$request->empreendimento_id);
                });
        }

        $vendas = $vendas->get();

        return view('vendas.index',
            [
                'vendas' => $vendas,
                'empreendimentos' => $empreendimentos,
                'vendedores' => $vendedores,
                'clientes' => $clientes
            ]
        )->withInput($request);
    }

    public function detail($id)
    {
        $venda = Venda::with(['apartamento.bloco.empreendimento','vendedor', 'cliente', 'status', 'trilhaDeVenda','etapas','subetapas'])->findOrFail($id);

        $etapasConcluidas = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::COMPLETA;
        });

        $etapaEmAndamento = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ADANTAMENTO;
        });

        $etapasEmEspera = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ESPERA;
        });

        $todasEtapasForamConcluidas = count($etapasConcluidas) === count($venda->etapas);
        $mostraBotaoDeConcluir = $todasEtapasForamConcluidas && $venda->status->id != StatusVendasEnum::VENDIDO;

        return view('vendas.detail',
            [
            'venda' => $venda,
            'etapasConcluidas' => $etapasConcluidas,
            'etapaEmAndamento' => $etapaEmAndamento,
            'etapasEmEspera' => $etapasEmEspera,
            'mostraBotaoDeConcluir' => $mostraBotaoDeConcluir
            ]
        );
    }

    public function create(Request $r)
    {
        if ($r->query('apartamento')) {
            $apartamento = Apartamento::with('bloco.empreendimento')->findOrFail($r->query('apartamento'));
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

        if(count($proximaEtapaEmEspera) > 0) {
            $prazo = new \DateTime();
            $prazo->add(new \DateInterval('P' . $proximaEtapaEmEspera->prazo . 'D'));
            $venda->etapas()->updateExistingPivot($proximaEtapaEmEspera->id, ['statusetapas_id' => StatusEtapasEnum::EM_ADANTAMENTO, 'prazo' => $prazo]);
        }
    }

    public function mudarStatusSubEtapa($vendaId, $subEtapaid)
    {
        $statusAntigo = DB::table('vendas')
                ->join('vendas_subetapas','vendas.id','=','vendas_subetapas.venda_id')
                ->where([['vendas.id','=',$vendaId],['vendas_subetapas.subetapa_id','=',$subEtapaid]])
                ->select('vendas_subetapas.statusetapas_id')
                ->first()->statusetapas_id;

        $statusNovo = in_array($statusAntigo,[StatusEtapasEnum::EM_ADANTAMENTO, StatusEtapasEnum::EM_ESPERA]) ? StatusEtapasEnum::COMPLETA : StatusEtapasEnum::EM_ADANTAMENTO;

        DB::table('vendas_subetapas')
            ->where([['vendas_subetapas.venda_id','=',$vendaId],['vendas_subetapas.subetapa_id','=',$subEtapaid]])
            ->update(['statusetapas_id' => $statusNovo]);

    }

    public function mudarStatusVenda($id, $status)
    {
        $venda = Venda::findOrFail($id);
        $venda->statusvendas_id = $status;
        $venda->save();

        if($status == StatusVendasEnum::VENDIDO)
            \Illuminate\Support\Facades\Request::session()->flash('success','Venda concludía com sucesso');
        else
            \Illuminate\Support\Facades\Request::session()->flash('success','Venda cancelada');
        
        return redirect()->action('VendaController@index');
    }

    public function pendencies()
    {

//        $emVencimento = \DB::table('vendas')
//            ->join('vendas_etapas', 'vendas.id','=','vendas_etapas.venda_id')
//            ->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO)
//            ->where('vendas.statusvendas_id','=',StatusVendasEnum::RESERVADO)
//            ->whereDate('vendas_etapas.prazo','=',DataService::SqlToday())
//            ->get();

        $vencidas = Venda::whereHas('etapas',function($q){
            $q->whereDate(
                'vendas_etapas.prazo','<', DataService::SqlToday()
            )->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO);

        })
            ->with('etapas')
            ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
            ->get();

        $emVencimento = Venda::whereHas('etapas',function($q){
            $q->whereDate(
                'vendas_etapas.prazo','=', DataService::SqlToday()
            )->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO);

        })
            ->with('etapas')
            ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
            ->get();

        $venceLogo = Venda::whereHas('etapas',function($q){
            $q->whereDate(
                'vendas_etapas.prazo','=', DataService::SqlTomorrow()
            )->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO);

        })
            ->with(['etapas','cliente','status','vendedor','apartamento'])
            ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
            ->get();

        return view('vendas.pendencies',[
            'vencidas' => $vencidas,
            'emVencimento' => $emVencimento,
            'venceLogo' => $venceLogo
        ]);

    }





}