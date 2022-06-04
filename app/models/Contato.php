<?php

namespace models;
use core\modelHelper;
use \PDO;

class Contato extends modelHelper{
    public $table = 'contato';

    public function __construct()
    {
        parent::__construct();
    }
}