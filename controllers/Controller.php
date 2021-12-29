<?php

namespace Controllers;

abstract class Controller
{
    public $action = 'index';

    // Force les classes filles à définir cette méthode
    abstract public function default();

    public function __construct() {
        // On teste si un paramètre action existe et s'il correspond à une action du contrôleur
        if(isset($_GET['action'])) {
            $this->action = $_GET['action'];; // On appelle cette action
        }
    }

    public function run() {
        $action = $this->action.'Action';
        return $this->{$action}();
    }

    protected function render ($view, $data = []) {

        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [

            'cache' => false,

        ]);

        return $twig->render($view, $data);
    }

    protected function error($message) {
        $data = [
            'erreur' => $message
        ];
        $this->render('error', $data);
        die(); // Pour terminer le script vu qu'il y a une erreur
    }
}