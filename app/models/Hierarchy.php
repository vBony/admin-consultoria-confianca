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

    public static function buscar($id = null){
        if($id === null){
            return (new Hierarchy())->buscarTodos();
        }else{
            return (new Hierarchy())->buscarPorId($id);
        }
    }

    public function buscarTodos(){
        $tabela = self::$table;

        $sql = "SELECT * FROM $tabela";
        $sql = $this->db->prepare($sql);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id){
        $tabela = self::$table;

        $sql = "SELECT * FROM $tabela WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}