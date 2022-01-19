<?php

class Admin {
    public $messages = [];
    private $emptyMessage = 'Campo obrigatório';

    public function validate($data){
        $this->name($data);
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
}