<?php
namespace models\flags;

class StatusAvaliacao {
    public static function aguardando(){
        return 0;
    }

    public static function emAtendimento(){
        return 1;
    }

    public static function atendido(){
        return 2;
    }

    public static function reprovado(){
        return 3;
    }
}