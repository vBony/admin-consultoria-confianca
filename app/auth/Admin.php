<?php
namespace auth;

use models\Admin as ModelAdmin;
use models\AccessToken;
use models\validators\Admin as AdminValidator;

class Admin{
    private $Admin;

    public function __construct(){
        $this->Admin = new ModelAdmin();
    }

    public function loginAfterRegister($id){
        $ModelAdmin = new ModelAdmin();

        $userData = $ModelAdmin->buscarPorId($id);
        $this->setSession($userData);
    }

    public function login($data){
        $messages = array();
        $userFind = array();

        $AdminValidator = new AdminValidator();
        $AdminValidator->email($data);
        $AdminValidator->password($data);

        if(empty($AdminValidator->getMessages())){
            $userFind = $this->Admin->buscarPorEmail($data['email']);

            if(!empty($userFind)){
                if($this->validatePassword($data['password'], $userFind['password'])){
                    $this->setSession($userFind);
                    return true;
                }else{
                    $messages['password'] = 'Senha inválida';
                }
            }else{
                $messages['email'] = 'Usuário não encontrado';
            }
        }else{
            $messages = $AdminValidator->getMessages();
        }

        return $messages;
    }

    public function logout(){
        $this->killSession();
    }

    public function validatePassword($password, $hash){
        return password_verify($password, $hash);
    }

    public function setSession($userData){
        $data = array();

        $ip = $this->getIpUser();

        $ModelToken = new AccessToken();
        $tokenFound = $ModelToken->buscarPorIp($ip, $userData['id']);

        if(!empty($tokenFound)){
            $data['accessToken'] = $this->setAccessToken($userData, $tokenFound['id'], true);
        }else{
            $data['accessToken'] = $this->setAccessToken($userData);
        }

        $data['user'] = $userData;

        $_SESSION['userSession'] = $data;
    }

    public function getIdUserLogged(){
        return $_SESSION['userSession']['accessToken']['idAdmin'];
    }

    public function setAccessToken($userData, $id = null, $recycle = false){
        $ModelToken = new AccessToken();
        $data = array();
        $data['ip'] = $this->getIpUser();
        $data['idAdmin'] = $userData['id'];
        $data['createdAt'] = date('Y-m-d H:i:s');
        $data['validUntil'] = $this->setTokenLifeTime();
        $data['token'] = $this->setToken($userData);

        if(!$recycle && $id != null){
            if($ModelToken->criar($data)){
                return $data;
            }
        }else{
            $data['id'] = $id;
            if($ModelToken->recycleToken($data)){
                return $data;
            }
        }
    }

    public function getIpUser(){
        return $_SERVER['REMOTE_ADDR'];
    }

    public function setTokenLifeTime(){
        return date('Y-m-d H:i:s', strtotime("+3 hours"));
    }

    public function setToken($userData){
        return md5($userData['id'] . rand(1,10000) . date('i:s') . rand(1,10000));
    }

    public function killSession(){
        $ModelToken = new AccessToken();
        $ipUser = $this->getIpUser();

        if(isset($_SESSION['userSession'])){
            $tokenFind = $ModelToken->buscarPorToken($_SESSION['userSession']['accessToken']['token']);

            if(!empty($tokenFind) && $ipUser == $tokenFind['ip']){
                $ModelToken->matarToken($tokenFind['id']);
                unset($_SESSION['userSession']);
            }
        }
    }

    public function isLogged(){
        if(!isset($_SESSION['userSession'])){
            exit('redirecionamento 1');
            $this->goToLogin();
        }else{
            $tokenSession = $_SESSION['userSession']['accessToken']['token'];
            $idUser = $_SESSION['userSession']['accessToken']['idAdmin'];

            if(!empty($tokenSession) && !empty($idUser)){
                if(!$this->validateToken($tokenSession, $idUser)){
                    $this->killSession();
                    $this->goToLogin();
                }
            }else{
                exit('redirecionamento 3');
                $this->goToLogin();
            }
        }
    }

    public function validateToken($token, $idUser){
        $ModelToken = new AccessToken();

        $ip = $this->getIpUser();
        $now = date('Y-m-d H:i:s');
        
        $tokenFind = $ModelToken->buscarPorToken($token);

        // Token existe?
        if(!empty($tokenFind)){
            echo "Token existe <br>";
            // O usuário é dono desse token?
            if($tokenFind['idAdmin'] == $idUser){
                echo "Token do usuario <br>";
                // O ip do usuário é o mesmo do token?
                if($ip == $tokenFind['ip']){
                    echo "mesmo ip <br>";
                    // Esse token está ativo?
                    if($tokenFind['active'] == 1){
                        echo "ta ativo";
                        // Esse token está vencido?
                        if(strtotime($now) > strtotime($tokenFind['createdAt']) && strtotime($now) < strtotime($tokenFind['validUntil'])){
                            return true;
                        }else{
                            echo 'vencido';
                        }
                    }
                }
            }

            exit;
            
            return false;
        }else{
            return false;
        }
    }

    public function goToLogin(){
        $loginUrl = \core\controllerHelper::getBaseUrl() . 'login';

        header("Location: $loginUrl");
    }
}