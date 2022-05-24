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

        $data['templateData']['user'] = $user;
        $data['templateData']['baseUrl'] = $baseUrl;
        $data['templateData']['path'] = 'usuarios';

        $this->loadView('usuario', $data);
    }

    public function buscarCargos(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $data['listas']['cargos'] = Hierarchy::buscar();

        $this->response($data);
    }

    public function buscar(){
        $admin = new Admin();
        $auth = new AuthAdmin();
        $auth->isLogged();

        $id = $this->safeData($_POST, 'id');

        if(!empty($id)){
            $data['usuario'] = $admin->buscarPorId($id, true);
        }else{
            $adminId = $auth->getIdUserLogged();
            $data['listas']['usuarios'] = $admin->buscar($adminId);
        }

        $this->response($data);
    }

    public function criarCodigo(){
        $auth = new AuthAdmin();
        $auth->isLogged();
        $erros = array();

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

    public function resetSenha(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $token = new AdminCreateToken();

        $adminId = $auth->getIdUserLogged();
        $loggedUser = $this->Admin->buscarPorId($adminId);

        if($loggedUser['hierarchy']['level'] > 1){
            $this->response(['error' => 'hierarchy']);
        }else{

            $idUsuario = $this->safeData($_POST, 'idUsuario');

            if(!empty($idUsuario)){
                $tokenFound = $token->buscarTokenSenhaPorAdmin($idUsuario);

                if(empty($tokenFound)){
                    $usuario = $this->Admin->buscarPorId($idUsuario);
                    $tokens = $token->salvar($usuario['idHierarchy'], $idUsuario, true);
                    $this->Admin->resetSenha($idUsuario);
    
                    if(!is_bool($tokens)){
                        $this->response([
                            'success'=>true,
                            'token' => $tokens['codigo']
                        ]);
                    }else{
                        $this->response(['error' => 'critical']);
                    }
                }else{
                    $this->response([
                        'success'=>true,
                        'token' => $tokenFound
                    ]);
                }
            }else{
                $this->response(['error' => 'critical']);
            }
            
        }


    }

    public function codigosDisponiveis(){
        $auth = new AuthAdmin();
        $auth->isLogged();

        $token = new AdminCreateToken();

        $this->response(['codigos' => $token->getDisponiveis()]);
    }
}