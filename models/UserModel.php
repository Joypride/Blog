<?php

namespace Models;

class UserModel extends Model {

    public function isEmailExist($email)
    {
        $r = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $r->bindValue('email', $email);
        $r->execute();
        return $r->fetch();
    }

    public function login($email, $password)
    {
        $r = $this->db->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
        $r->bindValue('email', $email);
        $r->bindValue('password', $password);
        $r->execute();
        return $r->fetch(PDO::FETCH_ASSOC);
    }

    public function register($name, $surname, $email, $password)
    {
        $r = $this->db->prepare('INSERT INTO user (name, surname, email, password) VALUES (:name, :surname, :email, :password)');
        $r->bindValue('name', $name);
        $r->bindValue('surname', $surname);
        $r->bindValue('email', $email);
        $r->bindValue('password', $password);
        $r->execute();

        // INSERT INTO user SET name = :name, surname = :surname, email = :email, password = :password'
    }

}