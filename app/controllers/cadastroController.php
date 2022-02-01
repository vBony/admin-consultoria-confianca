<?php
use models\validators\Admin as AdminValidator;
use models\Admin;
class cadastroController extends controllerHelper{
    public function index(){
        $data = array();
        $data['baseUrl'] = $this->baseUrl();

        $this->loadView('cadastro', $data);
    }

    public function cadastrar(){
        $this->loadValidator('Admin');
        $adminValidator = new AdminValidator('create');
        $adminValidator->validate($_POST);

        $adminModel = new Admin();

        if(!empty($adminValidator->getMessages())){
            $this->response(['error' => $adminValidator->getMessages()]);
        }else{
            if($adminModel->cadastrar($_POST)){
                $this->response(['response' => 'done']);
            }
        }
    }
}

?>