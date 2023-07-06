<?php
use core\controllerHelper;
class naoEncontradoController extends controllerHelper{
    public function index(){
        $baseUrl = $this->baseUrl();

        $data = array();
        $data['baseUrl'] = $baseUrl;

        $this->loadView('nao-encontrado', $data);
    }
}

?>