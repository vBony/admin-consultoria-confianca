<?php
namespace models\validators;
use models\Admin as modelAdmin;
use models\AdminCreateToken;

class Admin  {
    public $messages = [];
    private $emptyMessage = 'Campo obrigatório';
    private $type = '';

    public function __construct($type)
    {
        $this->type = $type;
    }


    public function validate($data){
        $this->name($data);
        $this->lastName($data);
        $this->email($data);

        if($this->type == 'create'){
            $this->passwordOnCreate($data);
            $this->validateCreateToken($data);
            $this->validateCreateToken($data);
        }
    }

    public function getMessages(){
        return $this->messages;
    }

    // name	lastName	email	urlAvatar	password	
    public function name($data){
        $name = $data['name'];

        if(!empty($name)){
            if(strlen($name) <= 2 || strlen($name) > 20)
                $this->messages['name'] = 'Digite apenas o primeiro nome';
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
        $Admin = new modelAdmin();

        if(empty($email)){
            $this->messages['email'] = $this->emptyMessage;
        }else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->messages['email'] = "Email inválido"; 
            }elseif($this->type == 'create'){
                $userFind = $Admin->buscarPorEmail($data['email']);

                if(!empty($userFind)){
                    $this->messages['email'] = "E-mail já está em uso";
                }
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
        }else{
            $this->messages['retypePassword'] = $this->emptyMessage;
        }
    }

    public function passwordOnCreate($data){
        $this->password($data);
        $this->retypePassword($data);
    }

    public function validateCreateToken($data){
        $token = $data['token'];

        $modelToken = new AdminCreateToken();

        if(!empty($token)){
            if(!$modelToken->validate($token)){
                $this->messages['token'] = 'Token inválido';
            }
        }else{
            $this->messages['token'] = $this->emptyMessage;
        }
    }
}

// 53151453
// Quadra 48, Conjunto F, Casa 29 - Vila São José (Brazlândia - DF)