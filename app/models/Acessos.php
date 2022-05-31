<?php

namespace models;
use sanitazerHelper;
use core\modelHelper;
use \PDO;
use \PDOException;

class Acessos extends modelHelper{
    private $table = 'acessos';

    public function __construct()
    {
        parent::__construct();
    }

    public function total($short = false){
        $sql = "SELECT count(*) as total FROM {$this->table}";
        $sql = $this->db->prepare($sql);
        $sql->execute();

        $data = $sql->fetch(PDO::FETCH_ASSOC);

        if($short){
            $sanitazer = new sanitazerHelper();
            
            return $sanitazer->numberFormatShort($data['total']);
        }else{
            return $data['total'];
        }
    }
}