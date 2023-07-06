<?php
use models\validators\Admin as AdminValidator;
use models\Admin;
use auth\Admin as AdminAuth;
use core\controllerHelper;
use models\AdminCreateToken;

class esqueciSenhaController extends controllerHelper{
    public function index(){
        $data = array();
        $data['baseUrl'] = $this->baseUrl();

        $this->loadView('esqueci-senha', $data);
    }

    public function resetarSenha(){
        $adminValidator = new AdminValidator();


        $adminAuth = new AdminAuth();
        $token = new AdminCreateToken();
        $adminModel = new Admin();
        
        
        $adminValidator->validateResetPassword($_POST);

        if(!empty($adminValidator->getMessages())){
            $this->response(['error' => $adminValidator->getMessages()]);
        }else{
            $admin = $adminModel->buscarPorEmail($_POST['email']);

            $sucesso = $adminModel->alterarSenha($admin['id'], $_POST);
            if($sucesso){
                $token->delete($_POST['token']);    
                $adminAuth->loginAfterRegister($admin['id']);

                $this->response(['success' => 1]);
            }else{
                exit('final');
                $this->response(['success' => 0]);
            }
        }
    }
}

?>