<?php
class controllerHelper{
    public function loadView($viewName, $viewData = array(), $show_header = true){
        extract($viewData);

        require 'app/views/'.$viewName.'.php';
    }

    public function loadTemplate($viewData = array()){
        extract ($viewData);

        require 'app/views/template.php';
    }

    public function loadViewInTemplate($viewName, $viewData = array()){
        extract($viewData);
        require 'app/views/'.$viewName.'.php';
    }

    public function loadValidator($validatorName){
        require 'app/models/validators/'.$validatorName.'.php';
    }

    public function baseUrl(){
        return $_ENV['BASE_URL'];
    }

    public function response($data){
        echo json_encode($data);
    }
}

?>