<?php

use core\controllerHelper;
use auth\Admin as AdminAuth;
class loginController extends controllerHelper{
    private $Auth;

    public function __construct()
    {
        $this->Auth = new AdminAuth();
    }

    public function index(){
        $data = array();
        $data['baseUrl'] = $this->baseUrl();
        
        $this->loadView('login', $data);
    }

    public function authenticate(){
        $data = $_POST;

        $loginResponse = $this->Auth->login($data);
        if(is_bool($loginResponse)){
            $this->response(['success' => 1]);
        }else{
            $this->response(['error' => $loginResponse]);
        }
    }
}
?>