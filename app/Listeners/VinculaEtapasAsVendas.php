<?php

namespace App\Listeners;

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
        $trilha = TrilhaDeVendas::with('etapas.subetapas')->findOrFail($event->venda->trilhadevendas_id);
        $this->vinculaPrimeiraEtapa($event->venda, $trilha);
        $this->vinculaSubEtapasDaPrimeiraEtapa($event->venda, $trilha);
        $this->vinculaEtapasRestantes($event->venda, $trilha);
    }

    private function vinculaPrimeiraEtapa($venda, $trilha)
    {
        $now = new \DateTime();
        $now->add(new \DateInterval('P'.$trilha->etapas[0]->prazo.'D'));
        $venda->etapas()->attach($trilha->etapas[0]->id,['prazo' => $now, 'statusetapas_id' => StatusEtapasEnum::EM_ADANTAMENTO]);
    }

    private function vinculaSubEtapasDaPrimeiraEtapa($venda, $trilha)
    {
        $subEtapasIds = [];
        foreach($trilha->etapas[0]->subetapas as $s){
            $subEtapasIds[$s->id] =  ['statusetapas_id' => StatusEtapasEnum::EM_ADANTAMENTO];
        }

        $venda->subEtapas()->attach($subEtapasIds);
    }

    private function vinculaEtapasRestantes($venda, $trilha)
    {
        $trilha->etapas->shift();
        $etapasIds = [];
        $subEtapasIds = [];
        foreach($trilha->etapas as $e){
            $etapasIds[$e->id] = ['statusetapas_id' => StatusEtapasEnum::EM_ESPERA];
            foreach($e->subetapas as $s){
                $subEtapasIds[$s->id] = ['statusetapas_id' => StatusEtapasEnum::EM_ESPERA];
            }
        }

        $venda->etapas()->attach($etapasIds);
        $venda->subEtapas()->attach($subEtapasIds);
    }


}
