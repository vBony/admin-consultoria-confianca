<?php
namespace models\sanitazers;
use sanitazerHelper;

class Solicitacoes extends sanitazerHelper{
    public static function name($name){
        return ucwords(strtolower($name));
    }

    public static function email($email){
        return strtolower($email);
    }

    public static function formasContato($formasContato){
        return json_encode($formasContato);
    }

    public static function showFormasContato($formasContato){
        $formasContato = array_keys(get_object_vars(json_decode($formasContato)));
        foreach($formasContato as $i => $formaContato){
            $formasContato[$i] = ucfirst($formaContato);
        }

        return $formasContato;
    }

    public static function observacao($observacao){
        return strip_tags($observacao);
    }

    public static function showCreatedAt($data){
        return (new sanitazerHelper())->diferencaDatasPorExtenso($data, 'passado_simples');
    }

    public static function naoAvaliador($registro){
        $registro['ipId'] = null;
        $registro['cpf'] = null;
        $registro['cpfConjuge'] = null;
        $registro['email'] = null;
        $registro['formasContato'] = array();
        $registro['telefone'] = null;

        return $registro;
    }

    public static function semDadosContato($registro){
        $registro['telefone'] = null;
        $registro['email'] = null;

        return $registro;
    }
}