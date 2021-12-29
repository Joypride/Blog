<?php

namespace Models;

class Model {

    protected static $db;
    
    //Constructeur créant l'objet PDO et l'affectant à $db
    // public function __construct() {
    //     $dsn = "mysql:host=localhost;dbname=blog";
    //     $login = "root";
    //     $mdp = '';
    //     $this->db = new \PDO($dsn, $login, $mdp);
    //     $this->db->query("SET NAMES 'utf8'");
    //     $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    // }

    public static function getDatabaseInstance() {
        if (!self::$db) {
            $dsn = "mysql:host=localhost;dbname=blog";
            $login = "root";
            $mdp = '';
            self::$db = new \PDO($dsn, $login, $mdp);
            self::$db->query("SET NAMES 'utf8'");
            self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }
}