<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
use models\Solicitacoes;
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

        $this->response(['solicitacao' => $solicitacao]);
    }
}

?>