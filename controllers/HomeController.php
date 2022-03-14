<?php 

namespace Controllers;

class HomeController extends Controller {

    public function default() {
        return $this->indexAction();
    }

    public function indexAction() {
        return $this->render('index.html.twig');
    }

    public function contactAction() {
        return $this->render('contact.html.twig');
    }

    public function registerAction() {
        return $this->render('register.html.twig');
    }

    public function error404Action() {
        return $this->render('404.html.twig');
    }

    public function logoutAction() {
        session_destroy();
        header('Location: /');
    }
}
