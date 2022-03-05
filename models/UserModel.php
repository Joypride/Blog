<?php

namespace Models;

class UserModel extends Model {

    private $email;
    private $password;

    public function emailExist($email)
    {
        $request = self::getDatabaseInstance()->prepare("SELECT * FROM user WHERE email = :email");
        $request->bindValue('email', $email);
        $request->execute();
        return $request->fetch();
    }

    public function pass($email)
    {
        $request = self::getDatabaseInstance()->prepare("SELECT password FROM user WHERE email = :email");
        $request->bindValue('email', $email);
        $request->execute();
        return $request->fetchColumn();
    }

    public function login($email, $password)
    {
        $request = self::getDatabaseInstance()->prepare('SELECT id, surname, name, email, photo, activated, isAdmin FROM user WHERE email = :email AND password = :password');
        $request->bindValue('email', $email);
        $request->bindValue('password', $password);
        $request->execute();
        return $request->fetch(\PDO::FETCH_ASSOC);
    }

    public function register($name, $surname, $email, $password)
    {
        $request = self::getDatabaseInstance()->prepare('INSERT INTO user (name, surname, email, password) VALUES (:name, :surname, :email, :password)');
        $request->bindValue('name', $name);
        $request->bindValue('surname', $surname);
        $request->bindValue('email', $email);
        $request->bindValue('password', $password);
        $request->execute();
    }

    public function find($id)
    {
        $request = self::getDatabaseInstance()->prepare("SELECT * FROM user WHERE id = :id");
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetch();
    }

    public function update($user)
    {
        $request = self::getDatabaseInstance()->prepare("UPDATE user SET name = :name, surname = :surname, email = :email, photo = :photo WHERE id = :id");
        $request->bindValue(':name', $user['name']);
        $request->bindValue(':email', $user['email']);
        $request->bindValue(':surname', $user['surname']);
        $request->bindValue(':photo', $user['image']);
        $request->bindValue(':id', $_SESSION['id']);
        return $request->execute();
    }

    public function allPending()
    {
        return self::getDatabaseInstance()->query("SELECT * FROM user WHERE activated = 0")->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE);
    }

    public function countAllPending()
    {
        return self::getDatabaseInstance()->query("SELECT COUNT(*) FROM user WHERE activated = 0")->fetchColumn();
    }

    public function delete($id)
    {
        $request = self::getDatabaseInstance()->prepare("DELETE FROM user WHERE id = :id");
        $request->bindValue(':id', $id);
        return $request->execute();
    }

    public function changePassword($password) {
        $request = self::getDatabaseInstance()->prepare("UPDATE user SET password = :password WHERE id = :id");
        $request->bindValue(':password', $password);
        $request->bindValue(':id', $_SESSION['id']);
        return $request->execute();
    }

    public function validateUser($id)
    {
        $request = self::getDatabaseInstance()->prepare("UPDATE user SET activated = 1 WHERE id = :id");
        $request->bindValue(':id', $id);
        return $request->execute();
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
