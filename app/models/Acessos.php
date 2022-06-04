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

    public function totalPorPais(){
        $sql  = "SELECT  ";
        $sql .= "    ig.countryCode, ";
        $sql .= "    count(acessos.id) as acessos ";
        $sql .= "FROM {$this->table} ";
        $sql .= "    INNER JOIN ipGeolocation ig on acessos.idIp = ig.id ";
        $sql .= "WHERE ig.id NOT IN (1, 2) ";
        $sql .= "GROUP BY ig.countryCode; ";

        $sql = $this->db->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0){
            $retorno = array();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($data as $row){
                $retorno[$row['countryCode']] = $row['acessos'];
            }

            return $retorno;
        }
    }

    public function totalPorMes($ano){
        $sql  = " SELECT ";
        $sql .= "     extract(MONTH from ac.dataCriacao) AS mes, ";
        $sql .= "     count(ac.id) AS total ";
        $sql .= " FROM {$this->table} ac ";
        $sql .= "     INNER JOIN ipGeolocation ig ON ac.idIp = ig.id ";
        $sql .= " WHERE ig.id NOT IN (1,2) ";
        $sql .= " AND extract(YEAR FROM ac.dataCriacao) = :ano ";
        $sql .= " GROUP BY mes; ";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':ano', $ano);
        $sql->execute();

        if($sql->rowCount() > 0){
            $retorno = array();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            // Formatando no padrao [mes] => total
            foreach ($data as $row){
                $retorno[$row['mes']] = $row['total'];
            }

            // Complementando array com os meses que não possuiram acessos
            $maxMeses = 12;
            for($i = 0; $i <= $maxMeses; $i++){
                if(!key_exists($i, $retorno)){
                    $retorno[$i] = 0;
                }
            }

            return $retorno;
        }
    }
}