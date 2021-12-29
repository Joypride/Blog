<?php

namespace Controllers;

use Models\UserModel;

class UserController extends Controller {
    
    public function default() {
        return $this->render('index.html.twig');
    }

    public function registerAction() {
        return $this->render('register.html.twig');
    }

    public function dataRegistrationAction() {
        $m = new UserModel();

        if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {

            $name = $_POST['name']; 
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $data = [
            "connexion" => $m->register($name, $surname, $email, $password)
        ];
        }
        return $this->render('register_process.html.twig', $data);
    }

    public function loginAction() {
        return $this->render('login.html.twig');
    }

    public function dataLoginAction() { 

        $m = new UserModel();

        if(isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $data = [
            "connexion" => $m->login($email)
            ];
            $this->render('admin.html.twig', $data);
        }     
    }
}