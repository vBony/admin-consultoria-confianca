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
        $erros = array();

        $adminId = $auth->getIdUserLogged();
        $idCargo = !empty($_POST['idCargo']) ? $_POST['idCargo'] : null;

        if(empty($idCargo)){
            $erros['cargo'] = 'Selecione um cargo';
        }

        $token = new AdminCreateToken();

        if($token->podeGerar() && empty($erros)){
            $lista = $token->salvar($idCargo);
            if(is_bool($lista)){
                $this->response(['error' => 400]);
            }else{
                $lista['success'] = 1;
                $this->response($lista);
            }
        }else{
            $erros['cargo'] = 'Limite máximo de códigos atingido';
        }

        if(!empty($erros)){
            $this->response(['erros' => $erros]);
        }
    }

    public function codigosDisponiveis(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $token = new AdminCreateToken();

        $this->response(['codigos' => $token->getDisponiveis()]);
    }
}