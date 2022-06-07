<?php
namespace models;

use core\modelHelper;
use \PDO;
use \PDOException;
use \models\sanitazers\Solicitacoes as Sanitazer;
use \models\flags\TipoSolicitacao as fTipoSolicitacao;
use \models\Admin;
use \models\flags\StatusAvaliacao;
use sanitazerHelper;

class Solicitacoes extends modelHelper{
    private $tabela = "simulacao";
    private $tableContato = "contato";
    private $sanitazerHelper;
    static private $formasContato = ['whatsapp', 'email', 'ligacao'];

    private $Admin;

    public function __construct()
    {
        parent::__construct();
        $this->Admin = new Admin();
        $this->sanitazerHelper = new sanitazerHelper();
    }

    public function buscar($filtros, $idAdmin){
        $status = $this->getStatus($filtros);
        $minhasSolicitacoes = $this->getMinhasSolicitacoes($filtros);

        $sql  = "SELECT * FROM {$this->tabela} ";
        $sql .= "WHERE id > 0 ";

        if(!empty($status)){
            $sql .= "AND statusAdmin IN ({$status['templates']}) ";
        }

        if($minhasSolicitacoes){
            $sql .= "AND idAdmin = :idAdmin";
        }

        $sql .= "ORDER BY createdAt DESC, statusAdmin DESC";
        $sql = $this->db->prepare($sql);

        if(!empty($status)){
            foreach($status['bindValues'] as $key => $value){
                $sql->bindValue($key, $value);
            }
        }

        if($minhasSolicitacoes){
            $sql->bindValue('idAdmin', $idAdmin);
        }

        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            return $this->montarRegistros($data);
        }
    }

    public function getStatus($filtros){
        if(key_exists('status', $filtros)){
            $status = $filtros['status'];

            if(count($status) > 0){
                return $this->mountListValues($status, 'status');
            }
        }
    }

    public function getMinhasSolicitacoes($filtros){
        if(isset($filtros['minhasSolicitacoes'])){
            if($filtros['minhasSolicitacoes'] === "true"){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * Monta os ids para usar no pdo
     * um array contendo os valores e os templates [:id1] => 1 (para o bind value)
     * e um array só com os templates, para usar na consulta
     */
    public function mountListValues($values, $templateName, ){
        $bindValues = array();
        $templates = array();

        if(count($values) > 0){
            foreach($values as $key => $value){
                array_push($templates, ":$templateName".$key);
                $bindValues[":$templateName".$key] = $value;
            }

            return [
                'bindValues' => $bindValues,
                'templates' => implode(',', $templates)
            ];
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
            return Sanitazer::naoAvaliador($solicitacao);
        }else{
            return Sanitazer::semDadosContato($solicitacao);
        }
    }

    public function tornarAvaliador($adminId, $id){
        $sql  = "UPDATE {$this->tabela} ";
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

    public function aprovar($idSolicitacao){
        $sql  = "UPDATE {$this->tabela} ";
        $sql .= "SET statusAdmin = :statusAdmin, adminDate = :adminDate ";
        $sql .= "WHERE id=:id ";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':statusAdmin', StatusAvaliacao::atendido());
        $sql->bindValue(':adminDate', $this->createdAt());
        $sql->bindValue(':id', $idSolicitacao);

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

    public function reprovar($idSolicitacao, $motivo){
        $sql  = "UPDATE {$this->tabela} ";
        $sql .= "SET statusAdmin = :statusAdmin, adminDate = :adminDate, observacaoAdmin = :observacaoAdmin ";
        $sql .= "WHERE id=:id ";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':statusAdmin', StatusAvaliacao::reprovado());
        $sql->bindValue(':adminDate', $this->createdAt());
        $sql->bindValue(':observacaoAdmin', $motivo);
        $sql->bindValue(':id', $idSolicitacao);

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

    public function total($short = false){
        $sql = "SELECT count(*) as total FROM {$this->tabela}";
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

    public function totalPorMes($ano){        
        $sql  = " SELECT ";
        $sql .= "     extract(MONTH from s.createdAt) AS mes, ";
        $sql .= "     count(s.id) AS total ";
        $sql .= " FROM {$this->tabela} s ";
        $sql .= " WHERE extract(YEAR FROM s.createdAt) = :ano ";
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

    public function maisRecentesDashboard(){
        $contato = new Contato();

        $sql  = " SELECT ";
        $sql .= "     s.id, ";
        $sql .= "     s.nome, ";
        $sql .= "     s.observacao, ";
        $sql .= "     1 as tipoSolicitacao, ";
        $sql .= "     s.statusAdmin, ";
        $sql .= "     s.createdAt ";
        $sql .= " FROM {$this->tabela} s ";
        $sql .= " UNION ";
        $sql .= " SELECT  ";
        $sql .= "     c.id, ";
        $sql .= "     c.nome, ";
        $sql .= "     c.mensagem, ";
        $sql .= "     2 as tipoSolicitacao, ";
        $sql .= "     c.statusAdmin, ";
        $sql .= "     c.createdAt ";
        $sql .= " FROM {$contato->table} c ";
        $sql .= " order by createdAt limit 4 ";
        $sql = $this->db->prepare($sql);

        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $key => $row){
                $data[$key]['tipoSolicitacaoDescricao'] = fTipoSolicitacao::getDescricao($row['tipoSolicitacao']);
                $data[$key]['eCreatedAt'] = Sanitazer::showCreatedAt($row['createdAt']);
            }

            return $data;
        }
    }

    public function minhasSolicitacoesCount($idAdmin){
        $sql = "SELECT count(*) as total FROM {$this->tabela} WHERE idAdmin = :admin";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':admin', $idAdmin);
        $sql->execute();

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        return $data['total'];
    }

    public function status($status, $short = false){
        $sql = "SELECT count(*) as total FROM {$this->tabela} WHERE statusAdmin = :status";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':status', $status);
        $sql->execute();

        $data = $sql->fetch(PDO::FETCH_ASSOC);

        if($short){
            $sanitazer = new sanitazerHelper();
            
            return $sanitazer->numberFormatShort($data['total']);
        }else{
            return $data['total'];
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
    public function email($id){
        $solicitacao = $this->buscarPorId($id);

        return $solicitacao['email'];
    }

    public function montarRegistro($registro){
        $backupAdminDate = $registro['adminDate'];

        $registro['formasContato'] = Sanitazer::showFormasContato($registro['formasContato']);
        $registro['createdAt'] = Sanitazer::showCreatedAt($registro['createdAt']);
        $registro['admin'] = $this->Admin->buscarPorId($registro['idAdmin']);
        $registro['adminDate'] = $this->sanitazerHelper->dataEHora($registro['adminDate'], true);
        return $registro;
    }


}