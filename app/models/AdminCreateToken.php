<?php
namespace models;

use core\modelHelper;
use \PDO;
use \PDOException;
use models\sanitazers\AdminCreateToken as sanitazer;

class AdminCreateToken extends modelHelper{
    private $table = "adminCreateToken";

    private $validadeToken = '12 hours';
    private $tamanhoToken = 10;
    private $limiteMaximo = 5;

    private $sanitazer;

    public function __construct()
    {
        parent::__construct();
        $this->sanitazer = new sanitazer();
    }

    public function buscarPorId($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function validate($token){
        $sql = "SELECT * FROM {$this->table} WHERE token = :token";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":token", $token);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }
    }

    public function validateResetPassword($token, $idUser){
        $sql = "SELECT * FROM {$this->table} WHERE token = :token AND idAdmin = :idAdmin AND resetPassword = 1";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":token", $token);
        $sql->bindValue(":idAdmin", $idUser);
        $sql->execute();

        if($sql->rowCount() > 0 ){
            return true;
        }else{
            return false;
        }
    }

    public function delete($token){
        $sql = "DELETE FROM {$this->table} WHERE token=:token";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":token", $token);

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

    public function salvar($idCargo, $idAdmin = null, $resetSenha = false){
        $token = $this->gerarToken();
        $validUntil = date('Y-m-d H:i:s',strtotime($this->validadeToken, strtotime($this->createdAt())));

        $sql  = "INSERT INTO {$this->table} (token, idHierarchy, createdAt, validUntil, idAdmin, resetPassword) ";

        if($idAdmin !== null && $resetSenha !== false){
            $sql .= "VALUES(:token, :idHierarchy, :createdAt, :validUntil, :idAdmin, 1)";
        }else{
            $sql .= "VALUES(:token, :idHierarchy, :createdAt, :validUntil, NULL, 0)";
        }

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":token", $token);
        $sql->bindValue(":idHierarchy", $idCargo);
        $sql->bindValue(":createdAt", $this->createdAt());
        $sql->bindValue(":validUntil", $validUntil);
        if($idAdmin !== null && $resetSenha !== false){
            $sql->bindValue(":idAdmin", $idAdmin);
        }

        try {
            $this->db->beginTransaction();

            $sql->execute();
            $id = $this->db->lastInsertId(PDO::FETCH_ASSOC);
            $this->db->commit();

            $token = $this->buscarPorId($id);

            return [
                'codigos' => $this->getDisponiveis(),
                'codigo' => $token['token']
            ];
        } catch(PDOException $e) {
            $this->db->rollback();

            exit($e->getMessage());
            // TODO: SALVAR ERRO NUMA TABELA DE LOG

            return false;
        }
    }

    public function buscarTokenSenhaPorAdmin($idAdmin){
        $sql = "SELECT * FROM {$this->table} WHERE idAdmin = :idAdmin AND resetPassword = true order by id desc limit 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":idAdmin", $idAdmin);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            return $data['token'];
        }
    }

    public function getDisponiveis($count = false){
        $now = $this->createdAt();

        if($count){
            $sql = "SELECT count(*) as quantidade FROM {$this->table} WHERE validUntil > :data AND idAdmin is null";
        }else{
            $sql  = "SELECT act.*, h.name as nomeHierarchy FROM {$this->table} act ";
            $sql .= "INNER JOIN hierarchy h on h.id = act.idHierarchy ";
            $sql .= "WHERE validUntil > :data AND idAdmin is null ";
        }

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":data", $now);
        $sql->execute();

        if($sql->rowCount() > 0){
            if($count){
                $quantidade = $sql->fetch(PDO::FETCH_ASSOC);
                return $quantidade['quantidade'];
            }else{
                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                return $this->sanitazer->listagem($result);
            }
        }
    }

    public function podeGerar(){
        $quantidade = $this->getDisponiveis(true);
        
        if($quantidade < $this->limiteMaximo){
            return true;
        }else{
            return false;
        }

    }

    public function setDono($idAdmin, $idToken){
        $sql = "UPDATE {$this->table} SET idAdmin=:idAdmin WHERE id=:idToken";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":idAdmin", $idAdmin);
        $sql->bindValue(":idToken", $idToken);
        $sql->execute();
    }

    public function gerarToken(){
        return substr(md5(time() . rand(1, 999999) . time()), 0, $this->tamanhoToken);
    }
}