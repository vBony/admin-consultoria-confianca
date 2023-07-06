<?php

namespace core;
use \PDO;
use \PDOException;
use core\Database;
class modelHelper{
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }   

    public static function createdAt(){
        return date('Y-m-d H:i:s');
    }
}
?>