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

        $data = array();
        $data['baseUrl'] = $this->baseUrl();
        $data['user'] = $this->Admin->buscarPorId($adminId);

        $this->loadView('home', $data);
    }

    // public function home(){
    //     $data = array();

    //     $this->loadView('home', $data);
    // }
}

?>