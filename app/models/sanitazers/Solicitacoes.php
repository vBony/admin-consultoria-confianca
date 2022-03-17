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
        $data = date('d/m/Y', strtotime($data));
        $hora = date('H:i:s', strtotime($data));
        return $data .' às '. $hora;
    }
}