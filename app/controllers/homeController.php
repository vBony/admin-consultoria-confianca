<?php
class homeController extends controllerHelper{
    public function index(){
        $data = array();
        $data['baseUrl'] = $this->baseUrl();

        $this->loadView('home', $data);
    }

    public function home(){
        $data = array();

        $this->loadView('home', $data);
    }
}

?>