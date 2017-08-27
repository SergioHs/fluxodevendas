<?php

namespace App;


abstract class StatusEtapasEnum {
    const COMPLETA = 1;
    const EM_ADANTAMENTO = 2;
    const EM_ESPERA = 3;

    static function getVerbose($status)
    {
        switch($status){
            case self::COMPLETA: return "Completa";
            case self::EM_ADANTAMENTO: return "Em andamento";
            case self::EM_ESPERA: return "Em espera";
        }

    }
}