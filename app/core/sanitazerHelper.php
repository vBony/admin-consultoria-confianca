<?php

use core\modelHelper;

class sanitazerHelper {
    public function diferencaDatasPorExtenso($dataFinal, $tipo = 'restante'){
        $agora = (new modelHelper())->createdAt();

        $agora      = new DateTime($agora);
        $diff       = $agora->diff( new DateTime($dataFinal));

        $restanteValidade = '';

        $dias = $diff->format('%d');
        $horas = $diff->format('%H');
        $minutos = $diff->format('%i');
        
        if($tipo == 'restante'){
            if($dias > 0){
                $restanteValidade = $dias . ($dias > 1 ? ' dias' : ' dia');
            }else{
                if($horas > 0){
                    $restanteValidade = $horas . ($horas > 1 ? ' horas' : ' hora');
                }else{
                    $restanteValidade = $minutos . ($minutos > 1 ? ' minutos' : ' minuto');
                }
            }
        }

        if($tipo == 'passado_simples'){
            if($dias > 0){
                return $dias . ' d';
            }else{
                if($horas > 0){
                    return $horas . ' h';
                }else{
                    if($minutos <= 1){
                        return ' agora';
                    }else{
                        return $minutos . ' min';
                    }
                }
            }
        }

        return $restanteValidade;
    }

    public function dataNormal($data){
        return date('d/m/Y',  strtotime($data));
    }

    public function hora($data){
        return date('H:i:s',  strtotime($data));
    }

    public function dataEHora($data, $divider = false){
        if(!$divider){
            return date('d/m/Y H:i:s',  strtotime($data));
        }else{
            return date('d/m/Y à\s H:i:s',  strtotime($data));
        }
    }
}