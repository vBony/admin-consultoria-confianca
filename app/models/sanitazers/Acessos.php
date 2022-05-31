<?php

namespace models\sanitazers;
use sanitazerHelper;

class AdminCreateToken extends sanitazerHelper{
    public function listagem(array $data){        
        if(!empty($data)){
            foreach($data as $key => $registro){
                $data[$key] = $this->setParaListagem($registro);
            }
        }

        return $data;
    }   

    public function setParaListagem($registro){
        $registro['restanteVencimento'] = $this->diferencaDatasPorExtenso($registro['validUntil']);

        return $registro;
    }
}