<?php
namespace models\flags;

class TipoSolicitacao {
    private static $simulacao = 1;
    private static $contato = 2;

    public static function map(){
        return [
            self::$contato => 'Dúvida',
            self::$simulacao => 'Simulação'
        ];
    }

    public static function contato(){
        return self::$contato;
    }

    public static function simulacao(){
        return self::$simulacao;
    }

    public static function getDescricao($id){
        $map = self::map();

        if(key_exists($id, $map)){
            return $map[$id];
        }
    }
}