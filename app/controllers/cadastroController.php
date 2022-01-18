<?php
class cadastroController extends controllerHelper{
    public function index(){
        $data = array();
        $data['baseUrl'] = $this->baseUrl();

        $this->loadView('cadastro', $data);
    }

    public function cadastrar(){
        
    }
}

?>