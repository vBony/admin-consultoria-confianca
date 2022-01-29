<?php

class Admin {
    public $messages = [];
    private $emptyMessage = 'Campo obrigatório';


    public function validate($data){
        $this->name($data);
        $this->lastName($data);
        $this->email($data);
    }

    public function getMessages(){
        return $this->messages;
    }

    // name	lastName	email	urlAvatar	password	
    public function name($data){
        $name = $data['name'];

        if(!empty($name)){
            if(strlen($name) <= 2 || strlen($name) > 20)
                $this->messages['name'] = 'Digite um nome válido';
        }else{
            $this->messages['name'] = $this->emptyMessage;
        }
    }

    public function lastName($data){
        $lastName = $data['lastName'];

        if(!empty($lastName)){
            if(strlen($lastName) <= 2 || strlen($lastName) > 20){
                $this->messages['lastName'] = 'Dado inválido';
            }
        }
    }

    public function email($data){
        $email = $data['email'];

        if(empty($email)){
            $this->messages['email'] = $this->emptyMessage;
        }else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->messages['email'] = "Email inválido"; 
            }
        }
    }

    public function password($data){
        $pass = $data['password'];

        if(!empty($pass)){
            if(strlen($pass) < 3){
                $this->messages['password'] = 'A senha deve conter no mínimo 3 caracteres';
            }
        }else{
            $this->messages['password'] = $this->emptyMessage;
        }
    }

    public function retypePassword($data){
        $pass = $data['password'];
        $rpass = $data['retypePassword'];

        if(!empty($rpass)){
            if($pass != $rpass){
                $this->messages['password'] = 'As senhas não conferem';
                $this->messages['retypePassword'] = 'As senhas não conferem';
            }
        }
    }

    public function passwordOnCreate($data){

    }
}