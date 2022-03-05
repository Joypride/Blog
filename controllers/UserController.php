<?php

namespace Controllers;

use Models\UserModel;
use Models\PostModel;
use Models\CommentModel;
use Models\CategoryModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Utils\Tools;

class UserController extends Controller {
    
    public function default() {
        return $this->render('index.html.twig');
    }

    public function registerAction() {
        return $this->render('register.html.twig');
    }

    public function dataRegistrationAction() {
        $model = new UserModel();

        if(Tools::getValue('name') && Tools::getValue('surname') && Tools::getValue('email') && Tools::getValue('password')) {
            $name = Tools::getValue('name'); 
            $surname = Tools::getValue('surname');
            $email = Tools::getValue('email');
            $password = password_hash(Tools::getValue('password'), PASSWORD_DEFAULT);
            $mail = new PHPMailer(TRUE);
            $data = [
            "connexion" => $model->register($name, $surname, $email, $password)
            ];

            try {
                /* Set the mail sender. */
                $mail->setFrom($email, $name . $surname);
    
                /* Add a recipient. */
                $mail->addAddress('joypride@hotmail.fr', 'Laurie');
    
                /* Set the mail message body. */
                $mail->Body = 'Nouvelle inscription nécessitant une action de votre part.';
    
                /* Finally send the mail. */
                $mail->send();
            }
            catch (Exception $e)
            {
                /* PHPMailer exception. */
                echo $e->errorMessage();
            }
            catch (\Exception $e)
            {
                /* PHP exception (note the backslash to select the global namespace Exception class). */
                echo $e->getMessage();
            }
        }
        return $this->render('register_process.html.twig', $data);
    }

    public function loginAction() {

        $model = new UserModel();
        $errorMessage = NULL;

        if(Tools::getValue('email') && Tools::getValue('password')) {
            $email = Tools::getValue('email');
            $pass = $model->pass($email);
            $password = password_verify(Tools::getValue('password'), $pass);

            if ($password) {
                $connexion = $model->login($email, $pass);

                if($connexion) {
                    if($connexion['activated'] == 1) {
                    $_SESSION['id'] = $connexion['id'];
                    $_SESSION['surname'] = $connexion['surname'];
                    $_SESSION['name'] = $connexion['name'];
                    $_SESSION['email'] = $connexion['email'];
                    $_SESSION['photo'] = $connexion['photo'];
                    $_SESSION['admin'] = $connexion['isAdmin'];
    
                    return $this->render('admin.html.twig', [
                        'surname' => $_SESSION['surname'],
                        'name' => $_SESSION['name'],
                        'email' => $_SESSION['email'],
                        'photo' => $_SESSION['photo'],
                        'admin' => $_SESSION['admin'],
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
        $posts = new PostModel();
        $tags = new CategoryModel();
        $id = (int)Tools::getSession('id');
        return $this->render('admin_post.html.twig', [
            'pending' => $posts->pending($id),
            'validated' => $posts->validated($id),
            'refused' => $posts->refused($id),
            'countp' => $posts->countPending($id),
            'countv' => $posts->countValidated($id),
            'countr' => $posts->countRefused($id),
            'tags' => $tags->read(),
        ]);
    }

    public function superAdminAction() {
        $posts = new PostModel();
        $comments = new CommentModel();
        $users = new UserModel();
        $id = (int)Tools::getSession('id');
        return $this->render('super_admin.html.twig', [
            'posts' => $posts->allPending(),
            'countp' => $posts->countAllPending(),
            'comments' => $comments->allPending(),
            'countc' => $comments->countAllPending(),
            'users' => $users->allPending(),
            'countu' => $users->countAllPending(),
        ]);
    }

    public function validateUserAction() {
        $user = new UserModel();
        $id = (int)$_GET['id'];
        $user->validateUser($id);
        $info = $user->find($id);
        $mail = new PHPMailer(TRUE);
        
        try {
            /* Set the mail sender. */
            $mail->setFrom('joypride@hotmail.fr', 'Laurie');
            /* Add a recipient. */
            $mail->addAddress($info['email'], $info['name'] . $info['surname']);
            $mail->Body = 'Bonne nouvelle ! Votre inscription a été validée, vous pouvez maintenant vous connecter sur votre espace.';
            $mail->send();
        }
        catch (Exception $e)
        {
            echo $e->errorMessage();
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
        
        header('Location: ?controller=user&action=superAdmin');
    }

    public function deleteAction()
    {
        $user = new UserModel();
        $id = (int)$_GET['id'];
        $user->delete($id);
        header('Location: ?controller=user&action=superAdmin');
    }

    public function settingsAction() {
        $model = new UserModel();
        $id = (int)$_GET['id'];
        return $this->render('settings.html.twig', ['info' => $model->find($id)]);
    }

    public function editInfoAction() {
        
        if (!empty($_FILES)) {

        $dossier = 'public/img/';
        $fichier = basename($_FILES['image']['name']);
        $taille_maxi = 50000000;
        $taille = filesize($_FILES['image']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['image']['name'], '.');

            if(!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
                $erreur = 'Seuls les fichiers de type png, gif, jpg ou jpeg sont acceptés';
            }
            if($taille>$taille_maxi) {
                $erreur = 'Le fichier est trop volumineux';
            }
            if(!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
                //Formatage du nom du fichier
                $fichier = strtr($fichier,
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichier);
                $path = './public/img/' . $fichier;
            }
            else {
                echo $erreur;
            }
            
            if (Tools::getValue('name') && Tools::getValue('surname') && Tools::getValue('email'))
            {            
                $m = new UserModel();
                    $user = [
                        'name' => Tools::getValue('name'), 
                        'surname' => Tools::getValue('surname'),
                        'email' => Tools::getValue('email'),
                        'id' => Tools::getSession('id'),
                        'image' => $path
                    ];
                    $m->update($user);

                    $_SESSION['surname'] = $user['surname'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['image'] = $user['image'];

                    return $this->render('admin.html.twig');
            }
        }
    }

    public function newPasswordAction() {
        $user = new UserModel();
        $id = Tools::getSession('id');
        return $this->render('new_password.html.twig', ['info' => $user->find($id)]);
    }

    public function changePasswordAction() {
        $user = new UserModel();
        $id = Tools::getSession('id');

        if(Tools::getValue('old_pass') && Tools::getValue('new_password') && Tools::getValue('confirm_password')) {
            $old = Tools::getValue('old_pass');
            $pwd = Tools::getValue('new_password');
            $new = Tools::getValue('confirm_password');
            $email = $_SESSION['email'];
            $actual = $user->pass($email);
            $error = NULL;
            $succes = NULL;

            if (password_verify($old, $actual)) {
                if ($pwd === $new) {
                    $password = password_hash($pwd, PASSWORD_DEFAULT);
                    $user->changePassword($password);
                    $succes = 'Votre nouveau mot de passe a bien été enregistré';
                } else {
                    $error = 'Vos mots de passe ne correspondent pas';
                }
            } else {
                $error = 'Votre ancien mot de passe ne correspond pas';
            }
            return $this->render('new_password.html.twig', ['error' => $error, 'success' => $succes]);
        }
    }

    public function logoutAction() {
        session_destroy();
        header('Location: /');
    }

    public function contactAction() {

        if (Tools::getValue('name') && Tools::getValue('surname') && Tools::getValue('email') && Tools::getValue('message')) {
            $name = Tools::getValue('name');
            $surname = Tools::getValue('surname');
            $email = Tools::getValue('email');
            $message = Tools::getValue('message');
            $mail = new PHPMailer(TRUE);
            $note = NULL;

            try {
            /* Set the mail sender. */
            $mail->setFrom($email, $name . $surname);

            /* Add a recipient. */
            $mail->addAddress('joypride@hotmail.fr', 'Laurie');

            /* Set the mail message body. */
            $mail->Body = $message;

            /* Finally send the mail. */
            $mail->send();
            }
            catch (Exception $e)
            {
            /* PHPMailer exception. */
            echo $e->errorMessage();
            }
            catch (\Exception $e)
            {
            /* PHP exception (note the backslash to select the global namespace Exception class). */
            echo $e->getMessage();
            }
            $note = 'Votre message a bien été envoyé !';
        } else {
            $note = 'Veuillez remplir tous les champs';
        }
        return $this->render('contact.html.twig', ['note' => $note]);
    }
}
