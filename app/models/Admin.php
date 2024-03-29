<?php
namespace models;
use core\modelHelper;
use \PDO;
use \PDOException;
use core\controllerHelper;
use auth\Admin as AuthAdmin;
use sanitazerHelper;

class Admin extends modelHelper{
    private $table = 'admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function cadastrar($data){
        $sql = "INSERT INTO {$this->table}
        (name, lastName, email, urlAvatar, password, idHierarchy, createdAt, updatedAt)
        VALUES(:name, :lastName, :email, 'none', :password, :idHierarchy, :created, :updated);";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':name', ucfirst(strtolower($data['name'])));
        $sql->bindValue(':lastName', ucfirst(strtolower($data['lastName'])));
        $sql->bindValue(':email', str_replace(' ', '', strtolower($data['email'])));
        $sql->bindValue(':password', password_hash($data['password'], PASSWORD_BCRYPT));
        $sql->bindValue(':created', date('Y-m-d H:i:s'));
        $sql->bindValue(':updated', date('Y-m-d H:i:s'));
        $sql->bindValue(':idHierarchy', 1);

        try {
            $this->db->beginTransaction();
            $sql->execute();
            $id = $this->db->lastInsertId(PDO::FETCH_ASSOC);
            $this->db->commit();

            return $id;
        } catch(PDOException $e) {
            $this->db->rollback();

            // TODO: SALVAR ERRO NUMA TABELA DE LOG

            return false;
        }
    }

    public function alterarSenha($id, $data){
        $sql = "UPDATE {$this->table} SET password= :password, resetPassword= 0, updatedAt= :updatedAt WHERE id= :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':password', password_hash($data['password'], PASSWORD_BCRYPT));
        $sql->bindValue(':updatedAt', date('Y-m-d H:i:s'));
        $sql->bindValue(':id', $id);
        $sql->execute();

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

    public function buscarPorEmail($email){
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':email', strtolower($email));
        $sql->execute();

        if($sql->rowCount() > 0){
           return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function buscarPorId($id, $safe = true){
        $data = array();

        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            if($safe){
                $data = $this->mountData( $this->getSafeData( $sql->fetch(PDO::FETCH_ASSOC) ) );
            }else{
                return $this->mountData( $sql->fetch(PDO::FETCH_ASSOC) );
            }
        }

        return $data;
    }

    public function getSafeData($data){
        unset($data['password']);
        return $data;
    }

    public function buscar($idExcecao){
        $data = array();

        $sql = "SELECT * FROM {$this->table} WHERE id != :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $idExcecao);
        $sql->execute();

        if($sql->rowCount() > 0){
            foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $user){
                $data[] = $this->mountData( $this->getSafeData($user));
            }

            return $data;
        }
    }

    public function resetSenha($idUsuario){
        $sql = "UPDATE {$this->table} SET resetPassword=1 WHERE id= :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $idUsuario);
        $sql->execute();
    }

    public function solicitouResetSenhaPorEmail($email){
        $sql = "SELECT * FROM {$this->table} WHERE email = :email and resetPassword = 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function buscarDashboard($idExcecao){
        $data = array();

        $sql = "SELECT * FROM {$this->table} WHERE id != :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $idExcecao);
        $sql->execute();

        if($sql->rowCount() > 0){
            foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $user){
                $data[] = $this->mountData( $this->getSafeData($user), true);
            }

            return $data;
        }
    }

    public function totalMembros($idExcecao){
        $data = array();

        $sql = "SELECT count(*) as total FROM {$this->table} WHERE id != :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $idExcecao);
        $sql->execute();

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        return $data['total'];
    }

    /**
     * Ajusta dados necessários para mostrar na tela
     */
    public function mountData($data, $horaPorExtenso = false){
        $auth = new AuthAdmin();
        $sanitazer = new sanitazerHelper();

        if($data['urlAvatar'] == 'none'){
            $data['urlAvatar'] = \core\controllerHelper::getBaseUrl() . 'app/assets/imgs/avatar/default.png';
        }else{
            $fileName =  $data['urlAvatar'];
            $data['urlAvatar'] = \core\controllerHelper::getBaseUrl() . 'app/assets/imgs/avatar/' . $fileName;
        }

        $data['hierarchy'] = Hierarchy::buscar($data['idHierarchy']);
        if(!$horaPorExtenso){
            $data['createdAtFormatted'] =  $sanitazer->dataEHora($data['createdAt'], true);
        }else{
            $data['createdAtFormatted'] =  $sanitazer->diferencaDatasPorExtenso($data['createdAt'], 'passado_simples');
        }

        return $data;
    }
}