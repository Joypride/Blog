<?php

namespace Controllers;

use Models\UserModel;
use Models\PostModel;

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
            $password = $_POST['password'];
            // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $data = [
            "connexion" => $m->register($name, $surname, $email, $password)
            ];
        }
        return $this->render('register_process.html.twig', $data);
    }

    public function loginAction() {

        $m = new UserModel();
        $errorMessage = NULL;

        if(isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            // $password = password_verify($_POST['password'], $m->getPassword());
            $password = $_POST['password'];
            $connexion = $m->login($email, $password);

            if($connexion) {
                if($connexion['activated'] == 1) {
                $_SESSION['id'] = $connexion['id'];
                $_SESSION['surname'] = $connexion['surname'];
                $_SESSION['name'] = $connexion['name'];
                $_SESSION['email'] = $connexion['email'];
                $_SESSION['photo'] = $connexion['photo'];

                return $this->render('admin.html.twig', [
                    'surname' => $_SESSION['surname'],
                    'name' => $_SESSION['name'],
                    'email' => $_SESSION['email'],
                    'photo' => $_SESSION['photo'],
                ]);
                } else {
                    $errorMessage = 'Votre profil n\'est pas encore activé';
                }
            }
            else {
                $errorMessage = 'Vos identifiants sont incorrects';
            }
        }
        return $this->render('login.html.twig', ['errorMessage' => $errorMessage]);
    }

    public function accountAction() {
        return $this->render('admin.html.twig');
    }

    public function adminPostAction() {
        $p = new PostModel();
        return $this->render('admin_post.html.twig', [
            'pending' => $p->pending(),
            'validated' => $p->validated(),
        ]);
    }

    public function logoutAction() {
        session_destroy();
        return $this->render('index.html.twig');
    }
}