<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
use models\Acessos;
use models\flags\StatusAvaliacao;
use models\Solicitacoes;

class homeController extends controllerHelper{
    private $Admin;

    public function __construct(){
        $this->Admin = new Admin();
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
        $data['templateData']['path'] = 'dashboard';

        $this->loadView('home', $data);
    }

    public function buscarDados(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $acessos = new Acessos();
        $solicitacoes = new Solicitacoes();
        
        $data['acessos'] = [
            'total' => $acessos->total(true)
        ];

        $data['solicitacoes'] = [
            'atendidas' => $solicitacoes->status(StatusAvaliacao::atendido(), true),
            'pendentes' => $solicitacoes->status(StatusAvaliacao::aguardando(), true),
            'reprovadas' => $solicitacoes->status(StatusAvaliacao::reprovado(), true),
            'ultimasSolicitacoes' => $solicitacoes->maisRecentesDashboard()
        ];

        $this->response($data);
    }

    public function getData(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $acessos = new Acessos();
        $solicitacoes = new Solicitacoes();

        $data = [
            'acessos' => $acessos->totalPorPais(),
            'acessosPorMes' => $acessos->totalPorMes(date('Y')),
            'solicitacoesPorMes' => $solicitacoes->totalPorMes(date('Y'))
        ]; 

        $this->response($data);
    }
}

?>