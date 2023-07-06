<?php

namespace models;
use core\modelHelper;
use \PDO;
use \PDOException;

class AccessToken extends modelHelper{
    private $table = 'accessToken';

    public function __construct()
    {
        parent::__construct();
    }

    public function buscarPorId($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);

        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorToken($token){
        $sql = "SELECT * FROM {$this->table} WHERE token = :token";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':token', $token);

        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorIp($ip, $idUser){
        $sql = "SELECT * FROM {$this->table} WHERE ip = :ip AND idAdmin = :idAdmin";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':ip', $ip);
        $sql->bindValue(':idAdmin', $idUser);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function matarToken($id){
        $sql = "UPDATE {$this->table} SET active = 0 WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        
        $sql->execute();
    }

    public function criar($data){
        $sql = "INSERT INTO {$this->table}
        (ip, idAdmin, createdAt, validUntil, active, token)
        VALUES(:ip, :id, :created, :valid, 1, :token)";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':ip', $data['ip']);
        $sql->bindValue(':id', $data['idAdmin']);
        $sql->bindValue(':created', $data['createdAt']);
        $sql->bindValue(':valid', $data['validUntil']);
        $sql->bindValue(':token', $data['token']);

        try {
            $this->db->beginTransaction();
            $sql->execute();
            $this->db->commit();

            return true;
        } catch(PDOException $e) {
            $this->db->rollback();

            // TODO: SALVAR ERRO NUMA TABELA DE LOG

            return false;
        }
        
    }

    public function recycleToken($data){
        $sql  = "UPDATE {$this->table} SET ";
        $sql .= "ip = :ip, ";
        $sql .= "createdAt = :created, ";
        $sql .= "validUntil = :valid, ";
        $sql .= "token = :token, ";
        $sql .= "active = :active ";
        $sql .= "WHERE id = :id";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':ip', $data['ip']);
        $sql->bindValue(':id', $data['id']);
        $sql->bindValue(':created', $data['createdAt']);
        $sql->bindValue(':valid', $data['validUntil']);
        $sql->bindValue(':token', $data['token']);
        $sql->bindValue(':active', 1);

        try {
            $this->db->beginTransaction();
            $sql->execute();
            $this->db->commit();

            return true;
        } catch(PDOException $e) {
            $this->db->rollback();

            exit($e->getMessage());
            // TODO: SALVAR ERRO NUMA TABELA DE LOG

            return false;
        }
    }
}