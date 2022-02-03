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

    public function validatePassword($password, $hash){
        return password_verify($password, $hash);
    }

    public function setSession($userData){
        $data = array();
        $this->killSession();

        $data['user'] = $userData;
        $data['accessToken'] = $this->setAccessToken($userData);

        $_SESSION['userSession'] = $data;
    }

    public function setAccessToken($userData){
        $ModelToken = new AccessToken();
        $data = array();
        $data['ip'] = $this->getIpUser();
        $data['idAdmin'] = $userData['id'];
        $data['createdAt'] = date('Y-m-d H:i:s');
        $data['validUntil'] = $this->setTokenLifeTime();
        $data['token'] = $this->setToken($userData);

        if($ModelToken->criar($data)){
            return $data;
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
                $this->goToLogin();
            }
        }
    }

    public function validateToken($token, $idUser){
        $ModelToken = new AccessToken();

        $ip = $this->getIpUser();
        $now = date('Y-m-d H:i:s');

        $tokenFind = $ModelToken->buscarPorToken($token);

        if(!empty($tokenFind)){
            if($tokenFind['idAdmin'] == $idUser){
                if($ip == $tokenFind['ip']){
                    if($tokenFind['active'] == 1){
                        if($now > $tokenFind['createdAt'] && $now < $tokenFind['validUntil']){
                            return true;
                        }
                    }
                }
            }

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