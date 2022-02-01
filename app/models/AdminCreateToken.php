<?php
namespace models;

use core\modelHelper;
use \PDO;

class AdminCreateToken extends modelHelper{
    private $table = "adminCreateToken";

    public function validate($token){

        $sql = "SELECT * FROM {$this->table} WHERE token = :token";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":token", $token);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }
    }
}