<?php
namespace models;

use core\modelHelper;
use \PDO;
use \PDOException;
use \models\sanitazers\Solicitacoes as Sanitazer;
use \models\Admin;

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
        $sql .= "ORDER BY createdAt AND statusAdmin ";
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
            return $solicitacao;
        }
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