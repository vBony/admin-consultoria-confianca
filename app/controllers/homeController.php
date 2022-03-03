<?php
use auth\Admin as AuthAdmin;
use models\Admin;
use core\controllerHelper;
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

    // public function home(){
    //     $data = array();

    //     $this->loadView('home', $data);
    // }
}

?>