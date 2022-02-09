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

    public function pass($email)
    {
        $r = self::getDatabaseInstance()->prepare("SELECT password FROM user WHERE email = :email");
        $r->bindValue('email', $email);
        $r->execute();
        return $r->fetchColumn();
    }

    public function login($email, $password)
    {
        $r = self::getDatabaseInstance()->prepare('SELECT id, surname, name, email, photo, activated, isAdmin FROM user WHERE email = :email AND password = :password');
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

    public function update($user)
    {
        $r = self::getDatabaseInstance()->prepare("UPDATE user SET name = :name, surname = :surname, email = :email WHERE id = :id");
        $r->bindValue(':name', $user['name']);
        $r->bindValue(':email', $user['email']);
        $r->bindValue(':surname', $user['surname']);
        $r->bindValue(':id', $_SESSION['id']);
        return $r->execute();
    }

    public function allPending()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM user WHERE activated = 0")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function delete($id)
    {
        $r = self::getDatabaseInstance()->prepare("DELETE FROM user WHERE id = :id");
        $r->bindValue(':id', $id);
        return $r->execute();
    }

    public function changePassword($password) {
        $r = self::getDatabaseInstance()->prepare("UPDATE user SET password = :password WHERE id = :id");
        $r->bindValue(':password', $password);
        $r->bindValue(':id', $_SESSION['id']);
        return $r->execute();
    }

    public function validateUser($id)
    {
        $r = self::getDatabaseInstance()->prepare("UPDATE user SET activated = 1 WHERE id = :id");
        $r->bindValue(':id', $id);
        return $r->execute();
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
