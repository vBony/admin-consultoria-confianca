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

    public function buscar($filtros, $idAdmin, $pagina = 1){
        $pagina = intval($pagina);

        $status = $this->getStatus($filtros);
        $minhasSolicitacoes = $this->getMinhasSolicitacoes($filtros);
        $tipoSolicitacao = $this->getTipoSolicitacao($filtros);

        $totalItens = $this->getCountSolicitacoes($filtros, $idAdmin);

        $porPagina = 7;
        $totalPages = ceil($totalItens / $porPagina);

        $pagina = ($pagina > $totalPages || $pagina < 1) ? 1 : $pagina;
        $startAt = $porPagina * ($pagina - 1);



        if($this->soSimulacao($tipoSolicitacao) || ( $this->todasSolicitacoes($tipoSolicitacao) ) || empty($tipoSolicitacao)){
            $sql  = "SELECT s.id, s.nome, s.idAdmin, s.statusAdmin, s.createdAt, 1 as tipoSolicitacao, s.formasContato, s.adminDate FROM {$this->tabela} s ";
            $sql .= "WHERE id > 0 ";
    
            if(!empty($status)){
                $sql .= "AND statusAdmin IN ({$status['templates']}) ";
            }
    
            if($minhasSolicitacoes){
                $sql .= "AND idAdmin = :idAdmin ";
            }
        }
        
        if(($this->todasSolicitacoes($tipoSolicitacao)) || empty($tipoSolicitacao)){
            $sql .= " UNION ";
        }

        if($this->soContato($tipoSolicitacao) || ($this->todasSolicitacoes($tipoSolicitacao)) || empty($tipoSolicitacao)){
            if($this->soContato($tipoSolicitacao)){
                $sql  = "SELECT c.id, c.nome, c.idAdmin, c.statusAdmin, c.createdAt, 2 as tipoSolicitacao, null as formasContato, c.adminDate FROM {$this->tableContato} c ";
            }else{
                $sql  .= "SELECT c.id, c.nome, c.idAdmin, c.statusAdmin, c.createdAt, 2 as tipoSolicitacao, null as formasContato, c.adminDate FROM {$this->tableContato} c ";
            }

            $sql .= "WHERE id > 0 ";

            if(!empty($status)){
                $sql .= "AND statusAdmin IN ({$status['templates']}) ";
            }
    
            if($minhasSolicitacoes){
                $sql .= "AND idAdmin = :idAdmin ";
            }
        }

        $sql .= "ORDER BY createdAt DESC, statusAdmin DESC LIMIT $startAt, $porPagina";       
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

        $data = array();
        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            $data = $this->montarRegistros($data);
        }

        return [
            'data' => $data,
            'paging' => [
                'total' => $totalPages,
                'atual' => $pagina
            ]
        ];
    }

    public function getCountSolicitacoes($filtros, $idAdmin){
        $status = $this->getStatus($filtros);
        $minhasSolicitacoes = $this->getMinhasSolicitacoes($filtros);
        $tipoSolicitacao = $this->getTipoSolicitacao($filtros);

        if($this->soSimulacao($tipoSolicitacao) || ( $this->todasSolicitacoes($tipoSolicitacao) ) || empty($tipoSolicitacao)){
            $sql  = "SELECT count(*) as total FROM {$this->tabela} s ";
            $sql .= "WHERE id > 0 ";
    
            if(!empty($status)){
                $sql .= "AND statusAdmin IN ({$status['templates']}) ";
            }
    
            if($minhasSolicitacoes){
                $sql .= "AND idAdmin = :idAdmin ";
            }

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

            $totalSimulacao = $sql->fetch(PDO::FETCH_ASSOC);
        }

        if($this->soContato($tipoSolicitacao) || ($this->todasSolicitacoes($tipoSolicitacao)) || empty($tipoSolicitacao)){
            $sql1  = "SELECT  count(*) as total FROM {$this->tableContato} c ";

            $sql1 .= "WHERE id > 0 ";

            if(!empty($status)){
                $sql1 .= "AND statusAdmin IN ({$status['templates']}) ";
            }
    
            if($minhasSolicitacoes){
                $sql1 .= "AND idAdmin = :idAdmin ";
            }

            $sql1 = $this->db->prepare($sql1);

            if(!empty($status)){
                foreach($status['bindValues'] as $key => $value){
                    $sql1->bindValue($key, $value);
                }
            }

            if($minhasSolicitacoes){
                $sql1->bindValue('idAdmin', $idAdmin);
            }

            $sql1->execute();

            $totalContato = $sql1->fetch(PDO::FETCH_ASSOC);
        }

        if($this->soSimulacao($tipoSolicitacao)){
            return $totalSimulacao['total'];
        }
        
        if($this->soContato($tipoSolicitacao)){
            return $totalContato['total'];
        }

        if(($this->todasSolicitacoes($tipoSolicitacao)) || empty($tipoSolicitacao)){
            return $totalContato['total'] + $totalSimulacao['total'];
        }
    }

    public function soSimulacao($tipoSolicitacao){
        if(!in_array(fTipoSolicitacao::contato(), $tipoSolicitacao) && in_array(fTipoSolicitacao::simulacao(), $tipoSolicitacao)){
            return true;
        }else{
            return false;
        }
    }

    public function soContato($tipoSolicitacao){
        if(in_array(fTipoSolicitacao::contato(), $tipoSolicitacao) && !in_array(fTipoSolicitacao::simulacao(), $tipoSolicitacao)){
            return true;
        }else{
            return false;
        }
    }

    public function todasSolicitacoes($tipoSolicitacao){
        if(in_array(fTipoSolicitacao::contato(), $tipoSolicitacao) && in_array(fTipoSolicitacao::simulacao(), $tipoSolicitacao)){
            return true;
        }else{
            return false;
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

    public function getTipoSolicitacao($filtros){
        if(isset($filtros['tiposSolicitacoes'])){
            if(count($filtros['tiposSolicitacoes']) > 0){
                return $filtros['tiposSolicitacoes'];
            }else{
                return array();
            }
        }else{
            return array();
        }
    }

    /**
     * Monta os ids para usar no pdo
     * um array contendo os valores e os templates [:id1] => 1 (para o bind value)
     * e um array só com os templates, para usar na consulta
     */
    public function mountListValues($values, $templateName){
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

    public function buscarPorId($id, $tipoSolicitacao = null){
        if(!empty($tipoSolicitacao)){
            $sql  = "SELECT tc.*, 2 as tipoSolicitacao FROM {$this->tableContato} tc WHERE tc.id = :id";
        }else{
            $sql  = "SELECT ts.*, 1 as tipoSolicitacao FROM {$this->tabela} ts WHERE ts.id = :id";
        }

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

    public function buscarParaAvaliacao($id, $idAdmin, $tipoSolicitacao = null){
        $solicitacao = $this->buscarPorId($id, $tipoSolicitacao);

        if($idAdmin != $solicitacao['idAdmin']){
            return Sanitazer::naoAvaliador($solicitacao);
        }else{
            return Sanitazer::semDadosContato($solicitacao);
        }
    }

    public function tornarAvaliador($adminId, $id, $tipoSolicitacao=null){
        if(!empty($tipoSolicitacao)){
            $sql  = "UPDATE {$this->tableContato} ";
        }else{
            $sql  = "UPDATE {$this->tabela} ";
        }
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

    public function aprovar($idSolicitacao, $tipoSolicitacao=null){
        if(!empty($tipoSolicitacao)){
            $sql  = "UPDATE {$this->tableContato} ";
        }else{
            $sql  = "UPDATE {$this->tabela} ";
        }
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

    public function reprovar($idSolicitacao, $motivo, $tipoSolicitacao=null){
        if(!empty($tipoSolicitacao)){
            $sql  = "UPDATE {$this->tableContato} ";
        }else{
            $sql  = "UPDATE {$this->tabela} ";
        }
        // $sql  = "UPDATE {$this->tabela} ";
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
        $sql .= "     extract(MONTH from s.createdAt) - 1 AS mes, ";
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
            $maxMeses = 11;
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

        $sql2 = "SELECT count(*) as total FROM {$this->tableContato} WHERE idAdmin = :admin";
        $sql2 = $this->db->prepare($sql2);
        $sql2->bindValue(':admin', $idAdmin);
        $sql2->execute();

        $simulacao = $sql->fetch(PDO::FETCH_ASSOC);
        $contato = $sql2->fetch(PDO::FETCH_ASSOC);

        return intval($simulacao['total']) + intval($contato['total']);
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

    public function podeTornarAvaliador($id, $idAdmin, $tipoSolicitacao = null){
        $solicitacao = $this->buscarPorId($id, $tipoSolicitacao);

        if($solicitacao['idAdmin'] > 0){
            if($solicitacao['idAdmin'] != $idAdmin){
                return false;
            }else{
                return 'already';
            }
        }

        return true;
    }

    public function isAvaliador($id, $idAdmin, $tipoSolicitacao = null){
        $solicitacao = $this->buscarPorId($id, $tipoSolicitacao);

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

    public function telefone($id, $tipoSolicitacao = null){
        if(!empty($id) && !empty($tipoSolicitacao)){
            $solicitacao = $this->buscarPorId($id, $tipoSolicitacao);
        }

        return $solicitacao['telefone'];
    }
    public function email($id, $tipoSolicitacao = null){
        if(!empty($id) && !empty($tipoSolicitacao)){
            $solicitacao = $this->buscarPorId($id, $tipoSolicitacao);
        }

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