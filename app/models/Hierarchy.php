<?php

namespace models;
use core\modelHelper;
use \PDO;

class Hierarchy extends modelHelper{
    private static $table = 'hierarchy';

    public function __construct()
    {
        parent::__construct();
    }

    public static function buscar(){
        return (new Hierarchy())->buscarTodos();
    }

    public function buscarTodos(){
        $tabela = self::$table;

        $sql = "SELECT * FROM $tabela";
        $sql = $this->db->prepare($sql);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}