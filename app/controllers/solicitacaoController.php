<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
use models\Estados;
use models\flags\StatusAvaliacao;
use models\Solicitacoes;
use models\TipoImovel;

class solicitacaoController extends controllerHelper{
    private $Admin;
    private $Solicitacoes;
    private $Auth;
    private $Sanitazer;

    public function __construct(){
        $this->Auth = new AuthAdmin();
        $this->Admin = new Admin();
        $this->Solicitacoes = new Solicitacoes();
        $this->Sanitazer = new sanitazerHelper();
    }

    public function id($id){
        $tipoSolicitacao = $this->safeData($_GET, 'tipo');

        $solicitacao = $this->Solicitacoes->buscarPorId($id, $tipoSolicitacao);

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

        $tipoSolicitacao = $this->safeData($_POST, 'tipoSolicitacao');

        $this->Auth->isLogged();

        $adminId = $this->Auth->getIdUserLogged();
        $user = $this->Admin->buscarPorId($adminId);

        $solicitacao = $this->Solicitacoes->buscarParaAvaliacao($_SESSION['idSolicitacao'], $adminId, $tipoSolicitacao);

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
        $tipoSolicitacao = $this->safeData($_POST, 'tipoSolicitacao');

        $podeTornarAvaliador = $this->Solicitacoes->podeTornarAvaliador($idSolicitacao, $adminId, $tipoSolicitacao);

        if($podeTornarAvaliador !== true){
            $message = '';

            if($podeTornarAvaliador == 'already'){
                $message = "Você já é avaliador dessa solicitação";
            }elseif($podeTornarAvaliador === false){
                $message = "Já existe um avaliador para esta solicitação";
            }

            return $this->response(['error' => $message]);
        }

        if(!empty($idSolicitacao) && $this->Solicitacoes->tornarAvaliador($adminId, $idSolicitacao, $tipoSolicitacao)){
            $this->response(['solicitacao' => $this->Solicitacoes->buscarParaAvaliacao($idSolicitacao, $adminId, $tipoSolicitacao)]);
        }else{
            $this->response(['error' => 'Não foi possível realizar essa solicitação, tente novamente mais tarde']);
        }
    }

    public function telefoneCliente(){
        $this->Auth->isLogged();
        $adminId = $this->Auth->getIdUserLogged();

        $idSolicitacao = $this->safeData($_POST, 'idSolicitacao');
        $tipoSolicitacao = $this->safeData($_POST, 'tipoSolicitacao');

        if(!empty($idSolicitacao)){
            $this->response(['telefone' => $this->Solicitacoes->telefone($idSolicitacao, $tipoSolicitacao)]);
        }else{
            $this->response(['error' => 'Você não é o avaliador dessa solicitação']);
        }
    }

    public function emailCliente(){
        $this->Auth->isLogged();
        // $adminId = $this->Auth->getIdUserLogged();

        $idSolicitacao = $this->safeData($_POST, 'idSolicitacao');
        $tipoSolicitacao = $this->safeData($_POST, 'tipoSolicitacao');

        if(!empty($idSolicitacao)){
            $this->response(['email' => $this->Solicitacoes->email($idSolicitacao, $tipoSolicitacao)]);
        }else{
            $this->response(['error' => 'Você não é o avaliador dessa solicitação']);
        }
    }

    public function aprovar(){
        $this->Auth->isLogged();
        $adminId = $this->Auth->getIdUserLogged();

        $idSolicitacao = $this->safeData($_POST, 'idSolicitacao');
        $tipoSolicitacao = $this->safeData($_POST, 'tipoSolicitacao');

        $solicitacao = $this->Solicitacoes->buscarPorId($idSolicitacao, $tipoSolicitacao);

        if(empty($solicitacao)){
            $this->response(['error' => 'Solicitação não encontrada']);
        }

        if($adminId != $solicitacao['idAdmin']){
            $this->response(['error' => 'Você não é o responsável por essa solicitação.']);
        }else{
            if($this->Solicitacoes->aprovar($idSolicitacao, $tipoSolicitacao)){
                $solicitacao = $this->Solicitacoes->buscarPorId($idSolicitacao, $tipoSolicitacao);


                $this->response([
                    'success' => true,
                    'status' => StatusAvaliacao::atendido(),
                    'date' => $solicitacao['adminDate'],
                ]);
            }else{
                $this->response(['fail' => true]);
            }
        }
    }

    public function reprovar(){
        $this->Auth->isLogged();
        $adminId = $this->Auth->getIdUserLogged();

        $idSolicitacao = $this->safeData($_POST, 'idSolicitacao');
        $tipoSolicitacao = $this->safeData($_POST, 'tipoSolicitacao');
        $solicitacao = $this->Solicitacoes->buscarPorId($idSolicitacao, $tipoSolicitacao);
        $motivo = $this->safeData($_POST, 'motivo');

        if($adminId != $solicitacao['idAdmin']){
            $this->response(['error' => 'Você não é o responsável por essa solicitação.']);
        }else{
            if($this->Solicitacoes->reprovar($idSolicitacao, $motivo, $tipoSolicitacao)){
                $solicitacao = $this->Solicitacoes->buscarPorId($idSolicitacao, $tipoSolicitacao);

                $this->response([
                    'success' => true,
                    'status' => StatusAvaliacao::reprovado(),
                    'date' => $solicitacao['adminDate'],
                    'motivo' => $solicitacao['observacaoAdmin']
                ]);
            }else{
                $this->response(['fail' => true]);
            }
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