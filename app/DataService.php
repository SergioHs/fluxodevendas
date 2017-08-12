<?php

namespace App;


class DataService
{
    public static $apenasDiasUteis = true;

    public static function Adia($prazo, \DateTime $aPartirDe)
    {
        $aPartirDe->add(new \DateInterval('P' . $prazo . 'D'));

        if(self::$apenasDiasUteis){
            if($aPartirDe->format('l') == "Saturday")
                $aPartirDe->add(new \DateInterval('P2D'));
            else if($aPartirDe->format('l') == "Sunday")
                $aPartirDe->add(new \DateInterval('P1D'));
        }


        return $aPartirDe;

    }
}