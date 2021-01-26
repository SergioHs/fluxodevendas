<?php

namespace App;


abstract class StatusVendasEnum {
    const VENDIDO = 1;
    const RESERVADO = 2;
    const CANCELADO = 3;

    static function getVerbose($status){
        switch ($status)
        {
            case self::VENDIDO: return "Vendido";
            case self::RESERVADO: return "Reservado";
            case self::CANCELADO: return "Cancelado";
        }
    }


}