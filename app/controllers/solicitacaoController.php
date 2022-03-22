<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
use models\Estados;
use models\Solicitacoes;
use models\TipoImovel;

class solicitacaoController extends controllerHelper{
    private $Admin;
    private $Solicitacoes;
    private $Auth;

    public function __construct(){
        $this->Auth = new AuthAdmin();
        $this->Admin = new Admin();
        $this->Solicitacoes = new Solicitacoes();
    }

    public function id($id){
        $solicitacao = $this->Solicitacoes->buscarPorId($id);

        $this->Auth->isLogged();

        $adminId = $this->Auth->getIdUserLogged();
        $user = $this->Admin->buscarPorId($adminId);
        $baseUrl = $this->baseUrl();

        $data = array();
        $data['baseUrl'] = $baseUrl;
        $data['user'] = $user;

        $data['templateData']['user'] = $user;
        $data['templateData']['baseUrl'] = $baseUrl;
        $data['templateData']['path'] = 'solicitacoes';

        if(!empty($solicitacao)){
            $_SESSION['idSolicitacao'] = $id;
            $this->loadView('solicitacao', $data);
        }else{
            $this->loadView('nao-encontrado', $data);
        }

    }

    public function buscar(){

        if(empty($_SESSION['idSolicitacao'])){
            exit;
        }

        $this->Auth->isLogged();

        $adminId = $this->Auth->getIdUserLogged();
        $user = $this->Admin->buscarPorId($adminId);

        $solicitacao = $this->Solicitacoes->buscarParaAvaliacao($_SESSION['idSolicitacao'], $adminId);

        $response = [
            'solicitacao' => $solicitacao,
            'listas' => $this->carregarListas()
        ];

        $this->response($response);
    }

    public function tornarAvaliador(){
        $this->Auth->isLogged();

        $adminId = $this->Auth->getIdUserLogged();
        $idSolicitacao = $this->safeData($_POST, 'idSolicitacao');

        $podeTornarAvaliador = $this->Solicitacoes->podeTornarAvaliador($idSolicitacao, $adminId);

        if($podeTornarAvaliador !== true){
            $message = '';

            if($podeTornarAvaliador == 'already'){
                $message = "Você já é avaliador dessa solicitação";
            }elseif($podeTornarAvaliador === false){
                $message = "Já existe um avaliador para esta solicitação";
            }

            return $this->response(['error' => $message]);
        }

        if(!empty($idSolicitacao) && $this->Solicitacoes->tornarAvaliador($adminId, $idSolicitacao)){
            $this->response(['solicitacao' => $this->Solicitacoes->buscarParaAvaliacao($idSolicitacao, $adminId)]);
        }else{
            $this->response(['error' => 'Não foi possível realizar essa solicitação, tente novamente mais tarde']);
        }
    }

    public function telefoneCliente(){
        $this->Auth->isLogged();
        $adminId = $this->Auth->getIdUserLogged();

        $idSolicitacao = $this->safeData($_POST, 'idSolicitacao');

        if(!empty($idSolicitacao) && $this->Solicitacoes->isAvaliador($idSolicitacao, $adminId)){
            $this->response(['telefone' => $this->Solicitacoes->telefone($idSolicitacao)]);
        }else{
            $this->response(['error' => 'Não foi possível realizar essa solicitação, tente novamente mais tarde']);
        }
    }

    private function carregarListas(){
        return [
            'estados' => Estados::get(),
            'tiposImovel' => TipoImovel::get(),
        ];
    }
}

?>