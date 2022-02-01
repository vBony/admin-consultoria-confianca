<?php
namespace models;
use core\modelHelper;

class Admin extends modelHelper{
    private $table = 'admin';

    public function cadastrar($data){
        $sql = "INSERT INTO {$this->table}
        (name, lastName, email, urlAvatar, password, idHierarchy, createdAt, updatedAt)
        VALUES(:name, :lastName, :email, 'none', :password, :idHierarchy, current_timestamp(), current_timestamp());";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':name', $data['name']);
        $sql->bindValue(':lastName', $data['lastName']);
        $sql->bindValue(':email', $data['email']);
        $sql->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $sql->bindValue(':idHierarchy', 1);
        
        if($sql->execute()){
            // pegar o ultimo id
        }else{
            return false;
        }
    }
}