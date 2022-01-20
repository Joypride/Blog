<?php

namespace Models;

class UserModel extends Model {

    private $email;
    private $password;

    public function emailExist($email)
    {
        $r = self::getDatabaseInstance()->prepare("SELECT * FROM user WHERE email = :email");
        $r->bindValue('email', $email);
        $r->execute();
        return $r->fetch();
    }

    public function login($email, $password)
    {
        $r = self::getDatabaseInstance()->prepare('SELECT id, surname, name, email, photo, activated FROM user WHERE email = :email AND password = :password');
        $r->bindValue('email', $email);
        $r->bindValue('password', $password);
        $r->execute();
        return $r->fetch(\PDO::FETCH_ASSOC);
    }

    public function register($name, $surname, $email, $password)
    {
        $r = self::getDatabaseInstance()->prepare('INSERT INTO user (name, surname, email, password) VALUES (:name, :surname, :email, :password)');
        $r->bindValue('name', $name);
        $r->bindValue('surname', $surname);
        $r->bindValue('email', $email);
        $r->bindValue('password', $password);
        $r->execute();
    }

    public function find($id)
    {
        $q = self::getDatabaseInstance()->prepare("SELECT * FROM user WHERE id = :id");
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        $q->execute();
        return $q->fetch();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}