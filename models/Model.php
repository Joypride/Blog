<?php

class Model {

    protected $db;
    
    //Constructeur créant l'objet PDO et l'affectant à $db
    public function __construct() {
        $dsn = "mysql:host=localhost;dbname=portfolio";
        $login = "root";
        $mdp = '';
        $this->db = new PDO($dsn, $login, $mdp);
        $this->db->query("SET NAMES 'utf8'");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}