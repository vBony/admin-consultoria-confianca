<?php

use core\controllerHelper;
use auth\Admin as AuthAdmin;
use models\Admin;
use models\Hierarchy;

class usuarioController extends controllerHelper{
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
        $data['listas']['cargos'] = Hierarchy::buscar();

        $data['templateData']['user'] = $user;
        $data['templateData']['baseUrl'] = $baseUrl;
        $data['templateData']['path'] = 'usuarios';

        $this->loadView('usuario', $data);
    }
}