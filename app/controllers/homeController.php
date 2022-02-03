<?php
use auth\Admin as AuthAdmin;
use core\controllerHelper;
class homeController extends controllerHelper{
    public function index(){
        $auth = new AuthAdmin();
        $auth->isLogged();
        
        $data = array();
        $data['baseUrl'] = $this->baseUrl();

        $this->loadView('home', $data);
    }

    // public function home(){
    //     $data = array();

    //     $this->loadView('home', $data);
    // }
}

?>