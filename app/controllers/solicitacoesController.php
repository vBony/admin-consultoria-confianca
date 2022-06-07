<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
use models\flags\StatusAvaliacao;
use models\Solicitacoes;
class solicitacoesController extends controllerHelper{
    private $Admin;
    private $Solicitacoes;

    public function __construct(){
        $this->Admin = new Admin();
        $this->Solicitacoes = new Solicitacoes();
    }

    public function index(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $adminId = $auth->getIdUserLogged();
        $user = $this->Admin->buscarPorId($adminId);
        $baseUrl = $this->baseUrl();

        $data = array();
        $data['baseUrl'] = $baseUrl;
        $data['user'] = $user;

        $data['templateData']['user'] = $user;
        $data['templateData']['baseUrl'] = $baseUrl;
        $data['templateData']['path'] = 'solicitacoes';

        $this->loadView('solicitacoes', $data);
    }

    public function buscar(){
        $auth = new AuthAdmin();
        $auth->isLogged();
        $adminId = $auth->getIdUserLogged();

        $filtros = !empty($_POST['filtros']) ? $_POST['filtros'] : array();

        $solicitacoes = $this->Solicitacoes->buscar($filtros, $adminId);

        $this->response([
            'solicitacoes' => $solicitacoes,
            'minhasSolicitacoes' => $this->Solicitacoes->minhasSolicitacoesCount($adminId),
            'status' => StatusAvaliacao::map()
        ]);
    }
}

?>