<?php

namespace App;


class DataService
{
    public static $apenasDiasUteis = true;

    public static function Adia($prazo, \DateTime $aPartirDe)
    {
        $aPartirDe->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
        $aPartirDe->add(new \DateInterval('P' . $prazo . 'D'));

        if(self::$apenasDiasUteis){
            if($aPartirDe->format('l') == "Saturday")
                $aPartirDe->add(new \DateInterval('P2D'));
            else if($aPartirDe->format('l') == "Sunday")
                $aPartirDe->add(new \DateInterval('P1D'));
        }


        return $aPartirDe;
    }

    public static function SqlToday()
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
        return $now->format('Y-m-d');
    }

    public static function SqlTomorrow()
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
        $tomorrow = $now->add(new \DateInterval('P1D'));
        return $tomorrow->format('Y-m-d');
    }

}