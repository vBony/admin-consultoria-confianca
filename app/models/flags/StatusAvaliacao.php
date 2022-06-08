<?php
namespace models\flags;

class StatusAvaliacao {
    private static $aguardando = 0;
    private static $emAtendimento = 1;
    private static $atendido = 2;
    private static $reprovado = 3;

    public static function map(){
        return [
            self::$aguardando => 'Aguardando',
            self::$emAtendimento => 'Em atendimento',
            self::$atendido => 'Atendido',
            self::$reprovado => 'Reprovado'
        ];
    }

    public static function aguardando(){
        return self::$aguardando;
    }

    public static function emAtendimento(){
        return self::$emAtendimento;
    }

    public static function atendido(){
        return self::$atendido;
    }

    public static function reprovado(){
        return self::$reprovado;
    }
}