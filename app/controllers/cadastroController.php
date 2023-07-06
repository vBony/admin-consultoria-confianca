<?php
use models\validators\Admin as AdminValidator;
use models\Admin;
use auth\Admin as AdminAuth;
use core\controllerHelper;
use models\AdminCreateToken;

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
        $adminAuth = new AdminAuth();
        $token = new AdminCreateToken();

        $adminModel = new Admin();

        if(!empty($adminValidator->getMessages())){
            $this->response(['error' => $adminValidator->getMessages()]);
        }else{
            $id = $adminModel->cadastrar($_POST);
            if(!is_bool($id)){
                $token->setDono($id, $_POST['token']);    
                $adminAuth->loginAfterRegister($id);
                $this->response(['success' => 1]);
            }else{
                $this->response(['success' => 0]);
            }
        }
    }
}

?>