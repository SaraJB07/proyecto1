<?php

namespace app\models\drivers;

use mysqli;

class ConexDB {
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = '';
    private $nameDB = 'proyecto1';

    private $conex = null;

    public function __construct()
    {
            $this->conex = new mysqli(
                $this->host,
                $this->user,
                $this->pwd,
                $this->nameDB
            );
        
        if ($this->conex->connect_error) {
            die('Error al conectarse con la base de datos ' . $this->conex->connect_error);
        } 
    }

    public function execSQL($sql){
        return $this->conex->query($sql);
    }

    public function close(){
        $this->conex->close();
    }

}