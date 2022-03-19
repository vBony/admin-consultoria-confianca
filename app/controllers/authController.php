<?php
use auth\Admin as AuthAdmin;
use core\controllerHelper;
class authController extends controllerHelper{
    private $Auth;

    public function __construct(){
        $this->Auth = new AuthAdmin();
    }

    public function id(){
        $this->Auth->isLogged();

        $adminId = $this->Auth->getIdUserLogged();
        $this->response(['id' => $adminId]);
    }
}

?>