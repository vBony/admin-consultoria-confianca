<?php

use core\controllerHelper;
class loginController extends controllerHelper{
    public function index(){
        $data = array();
        $data['baseUrl'] = $this->baseUrl();
        
        $this->loadView('login', $data);
    }
}
?>