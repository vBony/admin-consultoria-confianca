<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
class solicitacoesController extends controllerHelper{
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
        $data['templateData']['path'] = 'solicitacoes';

        $this->loadView('solicitacoes', $data);
    }

    // public function home(){
    //     $data = array();

    //     $this->loadView('home', $data);
    // }
}

?>