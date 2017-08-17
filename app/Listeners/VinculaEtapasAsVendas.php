<?php

namespace App\Listeners;

use App\DataService;
use App\Events\VendaCadastrada;
use App\StatusEtapasEnum;
use App\TrilhaDeVendas;
use App\Venda;
use StatusEtapa;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VinculaEtapasAsVendas
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VendaCadastrada  $event
     * @return void
     */
    public function handle(VendaCadastrada $event)
    {
        $trilha = TrilhaDeVendas::with(['etapas.subetapas','vendas'])->findOrFail($event->venda->trilhadevendas_id);
        $etapasEmOrdem = $trilha->etapas->sortBy(function($etapa,$key){
            return $etapa->pivot->ordem;
        });

        $primeiraEtapa = $etapasEmOrdem->shift();

        $this->vinculaPrimeiraEtapa($event->venda, $primeiraEtapa);
        $this->vinculaSubEtapasDaPrimeiraEtapa($event->venda, $primeiraEtapa);
        $this->vinculaEtapasRestantes($event->venda, $etapasEmOrdem);
    }

    private function vinculaPrimeiraEtapa($venda, $etapa)
    {
        $prazo = DataService::Adia($etapa->prazo, new \DateTime());
        $venda->etapas()->attach($etapa->id,['prazo' => $prazo, 'statusetapas_id' => StatusEtapasEnum::EM_ADANTAMENTO]);
    }

    private function vinculaSubEtapasDaPrimeiraEtapa($venda, $etapa)
    {
        $subEtapasIds = [];
        foreach($etapa->subetapas as $s){
            $subEtapasIds[$s->id] =  ['statusetapas_id' => StatusEtapasEnum::EM_ADANTAMENTO];
        }

        $venda->subEtapas()->attach($subEtapasIds);
    }

    private function vinculaEtapasRestantes($venda, $etapas)
    {
        $etapasIds = [];
        $subEtapasIds = [];
        foreach($etapas as $e){
            $etapasIds[$e->id] = ['statusetapas_id' => StatusEtapasEnum::EM_ESPERA];
            foreach($e->subetapas as $s){
                $subEtapasIds[$s->id] = ['statusetapas_id' => StatusEtapasEnum::EM_ESPERA];
            }
        }

        $venda->etapas()->attach($etapasIds);
        $venda->subEtapas()->attach($subEtapasIds);
    }


}
