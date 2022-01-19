<?php
class cadastroController extends controllerHelper{
    public function index(){
        $data = array();
        $data['baseUrl'] = $this->baseUrl();

        $this->loadView('cadastro', $data);
    }

    public function cadastrar(){
        $this->loadValidator('Admin');
        $adminValidator = new Admin();
        $adminValidator->validate($_POST);

        echo "<pre>";
        print_r($adminValidator->getMessages());
        echo "</pre>";
        exit;
    }
}

?>