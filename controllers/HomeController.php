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
}
