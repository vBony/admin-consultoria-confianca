<?php
namespace core;
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

    public static function getBaseUrl(){
        return $_ENV['BASE_URL'];
    }

    public function response($data){
        echo json_encode($data);
    }

    public function safeData($data, $key = null){
        if(!empty($key)){
            if(!isset($data[$key])){
                return null;
            }else{
                return $data[$key];
            }
        }

        if(!empty($data)){
            return $data;
        }else{
            return null;
        }
    }
}

?>