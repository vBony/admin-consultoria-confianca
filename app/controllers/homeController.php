<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
use models\Acessos;

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
        
        $data['acessos'] = [
            'total' => $acessos->total(true)
        ];

        $this->response($data);
    }
}

?>