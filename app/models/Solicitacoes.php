<?php
namespace models;

use core\modelHelper;
use \PDO;
use \PDOException;
use \models\sanitazers\Solicitacoes as Sanitazer;
use \models\Admin;
use \models\flags\StatusAvaliacao;

class Solicitacoes extends modelHelper{
    private $tabela = "simulacao";
    private $tableContato = "contato";
    static private $formasContato = ['whatsapp', 'email', 'ligacao'];

    private $Admin;

    public function __construct()
    {
        parent::__construct();
        $this->Admin = new Admin();
    }

    public function buscar(array $filtros){
        $sql  = "SELECT * FROM {$this->tabela}  ";
        $sql .= "ORDER BY createdAt DESC, statusAdmin DESC";
        // exit($sql);
        $sql = $this->db->prepare($sql);

        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $this->montarRegistros($data);
        }
    }

    public function buscarPorId($id){
        $sql  = "SELECT * FROM {$this->tabela} WHERE id = :id";
        // exit($sql);
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $this->montarRegistro($data);
        }
    }

    public function montarRegistros(array $registros){
        $retorno = array();

        foreach($registros as $i => $registro){
            $retorno[$i] = $this->montarRegistro($registro);
        }

        return $retorno;
    }

    public function buscarParaAvaliacao($id, $idAdmin){
        $solicitacao = $this->buscarPorId($id);

        if($idAdmin != $solicitacao['idAdmin']){
            return $this->montarNaoAvaliador($solicitacao);
        }else{
            return Sanitazer::semDadosContato($solicitacao);
        }
    }

    public function tornarAvaliador($adminId, $id){
        $sql  = "UPDATE u316339274_c_confianca.simulacao ";
        $sql .= "SET idAdmin = :idAdmin, statusAdmin= :statusAdmin ";
        $sql .= "WHERE id=:id ";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idAdmin', $adminId);
        $sql->bindValue(':statusAdmin', StatusAvaliacao::emAtendimento());
        $sql->bindValue(':id', $id);

        try {
            $this->db->beginTransaction();

            $sql->execute();
            $id = $this->db->lastInsertId(PDO::FETCH_ASSOC);
            $this->db->commit();

            return true;
        } catch(PDOException $e) {
            $this->db->rollback();

            exit($e->getMessage());
            // TODO: SALVAR ERRO NUMA TABELA DE LOG

            return false;
        }
    }

    public function podeTornarAvaliador($id, $idAdmin){
        $solicitacao = $this->buscarPorId($id);

        if($solicitacao['idAdmin'] > 0){
            if($solicitacao['idAdmin'] != $idAdmin){
                return false;
            }else{
                return 'already';
            }
        }

        return true;
    }

    public function isAvaliador($id, $idAdmin){
        $solicitacao = $this->buscarPorId($id);

        if($solicitacao['idAdmin'] > 0){
            if($solicitacao['idAdmin'] == $idAdmin){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

        return false;
    }

    public function telefone($id){
        $solicitacao = $this->buscarPorId($id);

        return $solicitacao['telefone'];
    }

    public function montarRegistro($registro){
        $registro['formasContato'] = Sanitazer::showFormasContato($registro['formasContato']);
        $registro['createdAt'] = Sanitazer::showCreatedAt($registro['createdAt']);
        $registro['admin'] = $this->Admin->buscarPorId($registro['idAdmin']);
        return $registro;
    }

    public function montarNaoAvaliador($registro){
        return Sanitazer::naoAvaliador($registro);
    }

}