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
            // $password = $_POST['password'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
            $pass = $m->pass($email);
            $password = password_verify($_POST['password'], $pass);

            if ($password) {
                $connexion = $m->login($email, $pass);

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
            'countp' => $p->countPending(),
            'countv' => $p->countValidated(),
        ]);
    }

    public function settingsAction() {
        $m = new UserModel();
        $id = (int)$_GET['id'];
        return $this->render('settings.html.twig', ['info' => $m->find($id)]);
    }

    public function editInfoAction() {

        // $dossier = 'public/img/';
        // $fichier = basename($_FILES['image']['name']);
        // $taille_maxi = 50000000;
        // $taille = filesize($_FILES['image']['tmp_name']);
        // $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        // $extension = strrchr($_FILES['image']['name'], '.');

        // if(!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
        //     $erreur = 'Seuls les fichiers de type png, gif, jpg ou jpeg sont acceptés';
        // }
        // if($taille>$taille_maxi) {
        //     $erreur = 'Le fichier est trop volumineux';
        // }
        // if(!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
        //     //Formatage du nom du fichier
        //     $fichier = strtr($fichier,
        //         'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        //         'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        //     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
        //     move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichier);
        //     $path = './public/img/' . $fichier;
        // }
        // else {
        //     echo $erreur;
        // }
        
        if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']))
        {

            $m = new UserModel();
                $user = [
                    'name' => $_POST['name'], 
                    'surname' => $_POST['surname'],
                    'email' => $_POST['email'],
                    'id' => $_SESSION['id'],
                    // 'image' => $path,
                ];
                $m->update($user);
                header('Location: ?controller=user&action=account');
        }
    }

    public function logoutAction() {
        session_destroy();
        header('Location: /');
    }
}