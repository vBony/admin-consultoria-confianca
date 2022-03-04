<?php

use core\controllerHelper;
use auth\Admin as AuthAdmin;
use models\Admin;
use models\Hierarchy;
use models\AdminCreateToken;

class usuarioController extends controllerHelper{
    public function __construct(){
        $this->Admin = new Admin();
    }

    public function index(){
        $auth = new AuthAdmin();
        $token = new AdminCreateToken();
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

    public function criarCodigo(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $adminId = $auth->getIdUserLogged();
        $user = $this->Admin->buscarPorId($adminId);
        $token = new AdminCreateToken();

        if($token->podeGerar()){
            $lista = $token->salvar(1);
            if(is_bool($lista)){
                $this->response(['error' => 400]);
            }else{
                $this->response(['codigos' => $lista]);
            }
        }else{
            $this->response(['cargo' => 'Limite máximo de códigos atingido']);
        }
    }

    public function codigosDisponiveis(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $token = new AdminCreateToken();

        $this->response(['codigos' => $token->getDisponiveis()]);
    }
}