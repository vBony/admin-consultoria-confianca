<?php

use core\modelHelper;

class sanitazerHelper {
    public function diferencaDatasPorExtenso($dataFinal){
        $agora = (new modelHelper())->createdAt();

        $agora            = new DateTime($agora);
        $diff       = $agora->diff( new DateTime($dataFinal));

        $restanteValidade = '';

        $dias = $diff->format('%d');
        $horas = $diff->format('%H');
        $minutos = $diff->format('%i');
        
        if($dias > 0){
            $restanteValidade = $dias . ($dias > 1 ? ' dias' : ' dia');
        }else{
            if($horas > 0){
                $restanteValidade = $horas . ($horas > 1 ? ' horas' : ' hora');
            }else{
                $restanteValidade = $minutos . ($minutos > 1 ? ' minutos' : ' minuto');
            }
        }

        return $restanteValidade;
    }
}