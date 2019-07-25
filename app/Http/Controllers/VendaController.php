<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Cliente;
use App\DataService;
use App\Empreendimento;
use App\Events\VendaCadastrada;
use App\StatusEtapasEnum;
use App\SubEtapa;
use App\TrilhaDeVendas;
use App\Venda;
use App\Vaga;
use App\Vendedor;
use App\User;
use App\Imobiliaria;
use Illuminate\Http\Request;
use App\StatusVendasEnum;
use App\StatusVenda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
       if (Auth::user()->permissao == 1){
          $vendedores = User::all();
          $clientes   = Cliente::all();
       }else{
          $vendedores = User::where('id', '=', Auth::user()->id)->get();
          $clientes   = Cliente::where('user_id', '=', Auth::user()->id)->get();
       }
       
       $empreendimentos = Empreendimento::all();
       $imobiliarias    = Imobiliaria::all();
       $statusVendas    = StatusVenda::all();
       
       $vendas = Venda::with(['apartamento.bloco.empreendimento','user','user.imobiliaria', 'cliente', 'status', 'trilhaDeVenda', 'etapas'])->orderBy('created_at','desc');
       
       if (Auth::user()->permissao != 1){
          $vendas->where('user_id','=',Auth::user()->id);
       }

        if($request->isMethod('post'))
        {
            if($request->has('user_id'))
                $vendas->where('user_id','=',$request->user_id);

            if($request->has('cliente_id'))
                $vendas->where('cliente_id','=',$request->cliente_id);

            if(isset($request->empreendimento_id))
                $vendas->whereHas('apartamento.bloco',function($q) use ($request){
                    $q->where('empreendimento_id','=',$request->empreendimento_id);
                });

            if(isset($request->imobiliaria_id))
                $vendas->with('user')->whereHas('user',function($q) use ($request){
                    $q->where('imobiliaria_id','=',$request->imobiliaria_id);
                });

            if(isset($request->statusvenda_id))
                $vendas->with('status')->whereHas('user',function($q) use ($request){
                    $q->where('statusvendas_id','=',$request->statusvenda_id);
                });
            if(isset($request->mudaStatusGaragem)) {
                dd($request->mudaStatusGaragem);
            }


        }

        $vendas = $vendas->get();
       
//       ********************* AQUI COMEÇA A TRETA ********************* 
       
//       dd($vendas);
       $etapasComTotais = DB::table('trilhasdevendas_etapas')
          ->where('totalizar', '=', 1)
          ->join('trilhasdevendas', 'trilhasdevendas.id', '=', 'trilhasdevendas_etapas.trilhadevendas_id')
          ->where('ativo', '=', 1)
          ->join('etapas', 'etapas.id', '=', 'trilhasdevendas_etapas.etapa_id')
          ->select('trilhasdevendas_etapas.*', 'trilhasdevendas.nome as nomeTrilha', 'etapas.nome as nomeEtapa')
          ->get();
       
//       dd($etapasComTotais);
       
       $totais = collect([]);
              
       foreach($etapasComTotais as $etapa){
          $vendasTrilha = $vendas->where('trilhadevendas_id', $etapa->trilhadevendas_id);
//          dd($vendasTrilha);
          
          $total = 0;
          foreach($vendasTrilha as $vendaTrilha){
             if($vendaTrilha->statusvendas_id == 3)
                continue;
             
             $reg = $vendaTrilha->etapas()->where('id', $etapa->etapa_id)->wherePivot('statusetapas_id', 2);
             if($reg)
               $total += $reg->count();
//             dd($total);
          }
          
//          dd($total);
          
          if(!$total)
             continue;
          
          $temp = collect([
             'nomeEtapa' => $etapa->nomeEtapa, 
             'quantidade' => $total
          ]);
          
          // se não tiver trilha, incluir
          if (!$totais->get($etapa->trilhadevendas_id)){
             $totais->put($etapa->trilhadevendas_id, [
                'nomeTrilha' => $etapa->nomeTrilha, 
                'etapas' => [$etapa->etapa_id => $temp]
             ]);
             continue;
          }
//          dd($totais);
          
          if (!array_key_exists($etapa->etapa_id, $totais[$etapa->trilhadevendas_id]['etapas'])){
             $temp2 = $totais[$etapa->trilhadevendas_id];
             $temp2['etapas'] = array_add($totais[$etapa->trilhadevendas_id]['etapas'], $etapa->etapa_id, $temp);
             $totais[$etapa->trilhadevendas_id] = $temp2;
             continue;
          }
       }
       
//       dd($totais);
       
//       ********************* E VAI ATÉ AQUI ********************* 
       
        $request->flash();

        return view('vendas.index',
            [
                'vendas'          => $vendas,
                'empreendimentos' => $empreendimentos,
                'vendedores'      => $vendedores,
                'clientes'        => $clientes,
                'imobiliarias'    => $imobiliarias,
                'statusvendas'    => $statusVendas,
                'totais'          => $totais
            ]
        );
    }

    public function detail($id)
    {
        $venda = Venda::with(['apartamento.bloco.empreendimento','vendedor', 'cliente', 'status', 'trilhaDeVenda','etapas','subetapas'])
            ->findOrFail($id);

        if($venda->vaga_id!==NULL) {
            $vaga = Vaga::findOrFail($venda->vaga_id);
            $venda->vaga = $vaga;
        }
        $venda->etapas = $venda->etapas->sortBy(function($v) {
            return $v->pivot->ordem;
        });


        $etapasConcluidas = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::COMPLETA;
        });

        $etapaEmAndamento = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ADANTAMENTO;
        });

        $etapasEmEspera = $venda->etapas->filter(function($v,$k){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ESPERA;
        });
       
        $etapasEmAtraso = $venda->etapas->filter(function($v,$k){
            return $v->pivot->prazo < DataService::SqlToday() 
               && $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ADANTAMENTO;
        });

        $todasEtapasForamConcluidas = count($etapasConcluidas) === count($venda->etapas);
        $mostraBotaoDeConcluir = $todasEtapasForamConcluidas && $venda->status->id != StatusVendasEnum::VENDIDO;

        return view('vendas.detail',
            [
            'venda'                 => $venda,
            'etapasConcluidas'      => $etapasConcluidas,
            'etapaEmAndamento'      => $etapaEmAndamento,
            'etapasEmEspera'        => $etapasEmEspera,
            'etapasEmAtraso'        => $etapasEmAtraso,
            'mostraBotaoDeConcluir' => $mostraBotaoDeConcluir,
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

//        $vendedores = Vendedor::get();
        $vendedores = User::where('ativo', '=', 1)->get();
       
       if (Auth::user()->permissao == 1){
          $clientes   = Cliente::all();
       }else{
          $clientes   = Cliente::where('user_id', '=', Auth::user()->id)->get();
       }
       
        $trilhas = TrilhaDeVendas::where('ativo', '=', 1)->get();
        $empreendimentos = Empreendimento::get();
        $vagas = Vaga::where('empreendimento_id','=', $apartamento->bloco->empreendimento->id)->get();
        return view('vendas.create', ['vagas'=>$vagas, 'vendedores' => $vendedores, 'clientes' => $clientes, 'apartamento' => $apartamento, 'trilhas' => $trilhas, 'empreendimentos' => $empreendimentos, 'cliente' => isset($cliente) ? $cliente : null]);
    }

    public function store(Request $r)
    {
       $this->validate($r,[
            'cliente_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'trilhadevendas_id' => 'required|numeric',
            'apartamento_id' => 'required|numeric',
            'vaga_id' => 'nullable|numeric'
        ]);
        if (Venda::where('apartamento_id', '=', $r->apartamento_id)->where('trilhadevendas_id', '=', $r->trilhadevendas_id)->exists()) {
            Session::flash('error', 'O apartamento selecionada já foi reservado');
            return redirect('empreendimento');
            die();
         }
        $venda = new Venda();
        $venda->fill($r->all());
        $venda->statusvendas_id = StatusVendasEnum::RESERVADO;
        $venda->save();
       if($r->vaga_id) {
            if (Venda::where('apartamento_id', '=', $r->apartamento_id)->where('trilhadevendas_id', '=', $r->trilhadevendas_id)->where('vaga_id', '=', '')->exists()) {
                Session::flash('error', 'A vaga selecionada já foi reservada');
                return redirect('empreendimento');
                die();
            }
           $vaga = Vaga::findOrFail($r->vaga_id);
           $vaga->status = 1;
           $vaga->save();
       }
        event(new VendaCadastrada($venda));

        $apartamento = Apartamento::with('bloco.empreendimento')->findOrFail($r->apartamento_id);

        activity()
            ->by(Auth::id())
            ->on($venda)
            ->log("Iniciou uma venda." . " Vendedor: " .  User::findOrFail($r->user_id)->nome .  ". Cliente: " . Cliente::findOrFail($r->cliente_id)->nome . ". Empreendimento: "  . $apartamento->bloco->empreendimento->nome .  ". Bloco: " .  $apartamento->bloco->nome . ". Apartamento: " . $apartamento->numero);

        $r->session()->flash('success', 'Venda iniciada com sucesso');
        return redirect()->action('VendaController@index');

    }

    public function concluirEtapaEmAndamento($id)
    {
        $venda = Venda::with('etapas')->findOrFail($id);
        $etapaEmAndamento = $venda->etapas->filter(function($v,$k){
           return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ADANTAMENTO;
        })->first();

        activity()
            ->by(Auth::id())
            ->on($venda)
            ->log("Concluiu etapa " . $etapaEmAndamento->nome . " da venda #" . $venda->id);

        $proximaEtapaEmEspera = $venda->etapas->filter(function($v,$k) use ($etapaEmAndamento){
            return $v->pivot->statusetapas_id == StatusEtapasEnum::EM_ESPERA &&
                $v->pivot->ordem == $etapaEmAndamento->pivot->ordem + 1;
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

        activity()
            ->on(Venda::findOrFail($vendaId))
            ->by(Auth::id())
            ->log("Atualizou sub-etapa " . SubEtapa::findOrFail($subEtapaid)->nome . " da venda #".$vendaId . " de "  . StatusEtapasEnum::getVerbose($statusAntigo) . " para " . StatusEtapasEnum::getVerbose($statusNovo) );

        DB::table('vendas_subetapas')
            ->where([['vendas_subetapas.venda_id','=',$vendaId],['vendas_subetapas.subetapa_id','=',$subEtapaid]])
            ->update(['statusetapas_id' => $statusNovo]);

    }

    public function mudarStatusVenda($id, $status)
    {
        $venda = Venda::findOrFail($id);
        if($venda->vaga_id) {
        $vaga = Vaga::findOrFail($venda->vaga_id);
        $vaga->status='0';
        $vaga->save();
        }
        $venda->statusvendas_id = $status;
        $venda->save();
    

        activity()
            ->by(Auth::id())
            ->on($venda)
            ->log("Trocou status da venda #".$venda->id . " para " . StatusVendasEnum::getVerbose($status));
            
        if($status == StatusVendasEnum::VENDIDO)
            \Illuminate\Support\Facades\Request::session()->flash('success','Venda concluída com sucesso');
        else 
                        
          
            \Illuminate\Support\Facades\Request::session()->flash('success','Venda cancelada');

            return redirect()->action('VendaController@index');
        
        }

    public function pendencies()
    {
       $role = Auth::user()->permissao != 1;
       
        $vencidas = Venda::whereHas('etapas',function($q){
            $q->whereDate('vendas_etapas.prazo','<', DataService::SqlToday())
               ->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO);})
           ->with(['etapas','cliente','status','user','apartamento.bloco.empreendimento'])
           ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
           ->when($role, function ($query) use ($role) {
                    return $query->where('user_id', '=', Auth::user()->id);})
           ->get();
       
//        if (Auth::user()->permissao != 1){
//           $query->where('user_id', '=', Auth::user()->id);
//        }
//       
//        $vencidas = $query->get();
       
//       dd($vencidas);

        $emVencimento = Venda::whereHas('etapas',function($q){
            $q->whereDate('vendas_etapas.prazo','=', DataService::SqlToday())
               ->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO);})
           ->with(['etapas','cliente','status','user','apartamento.bloco.empreendimento'])
           ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
           ->when($role, function ($query) use ($role) {
                    return $query->where('user_id', '=', Auth::user()->id);})
           ->get();
       
//        if (Auth::user()->permissao != 1){
//           $emVencimento->where('user_id', '=', Auth::user()->id)->get();
//        }
       
//        $emVencimento->get();

        $venceLogo = Venda::whereHas('etapas',function($q){
            $q->whereDate('vendas_etapas.prazo','>=', DataService::SqlTomorrow())
               ->whereDate('vendas_etapas.prazo','<', DataService::SqlThreeDays())
               ->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO);})
           ->with(['etapas','cliente','status','user','apartamento.bloco.empreendimento'])
           ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
           ->when($role, function ($query) use ($role) {
                    return $query->where('user_id', '=', Auth::user()->id);})
           ->get();
       

        $venceTresDias = Venda::whereHas('etapas',function($q){
            $q->whereDate('vendas_etapas.prazo','>=', DataService::SqlThreeDays())
               ->whereDate('vendas_etapas.prazo','<', DataService::SqlOneWeek())
               ->where('vendas_etapas.statusetapas_id','=',StatusEtapasEnum::EM_ADANTAMENTO);})
           ->with(['etapas','cliente','status','user','apartamento.bloco.empreendimento'])
           ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
           ->when($role, function ($query) use ($role) {
                    return $query->where('user_id', '=', Auth::user()->id);})
           ->get();
       

        $venceUmaSemana = Venda::whereHas('etapas',function($q){
            $q->whereDate('vendas_etapas.prazo','>=', DataService::SqlOneWeek())
               ->where('vendas_etapas.statusetapas_id','>=',StatusEtapasEnum::EM_ADANTAMENTO);})
           ->with(['etapas','cliente','status','user','apartamento.bloco.empreendimento'])
           ->where('statusvendas_id','=', StatusVendasEnum::RESERVADO)
           ->when($role, function ($query) use ($role) {
                    return $query->where('user_id', '=', Auth::user()->id);})
           ->get();

        $nenhumaPendencia = !$vencidas->count() && !$emVencimento->count() && !$venceLogo->count();
       
//       dd($emVencimento);
       
        return view('vendas.pendencies',[
            'vencidas' => $vencidas,
            'emVencimento' => $emVencimento,
            'venceLogo' => $venceLogo,
            'venceTresDias' => $venceTresDias,
            'venceUmaSemana' => $venceUmaSemana,
            'nenhumaPendencia' => $nenhumaPendencia
        ]);

    }
   
   public function excluirJustificativa($id){
      $venda = Venda::findOrFail($id);
      
      if($venda->user_id != Auth::user()->id) return;
      
      $venda->justificativa = null;
      $venda->save();
      
      activity()
         ->by(Auth::id())
         ->on($venda)
         ->log("Apagou a justificativa de atraso da venda #" . $venda->id);
   }
   
   public function salvarJustificativa($id, $texto){
      $venda = Venda::findOrFail($id);
      
      if($venda->user_id != Auth::user()->id) return;
      
      $venda->justificativa = $texto;
      $venda->save();
      
      activity()
         ->by(Auth::id())
         ->on($venda)
         ->log("Informou justificativa de atraso '" . $texto . "', na venda #" . $venda->id);
   }
}