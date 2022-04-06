<?php

namespace Models;

class Model {

    protected static $db;

    public static function getDatabaseInstance() {
        if (!self::$db) { // Vérifie l'existence d'une instance
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
