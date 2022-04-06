<?php

namespace Controllers;
use Utils\Tools;

abstract class Controller
{
    public $action = 'index';

    // Force les classes filles à définir cette méthode
    abstract public function default();

    public function __construct() {
        // On teste si un paramètre action existe et s'il correspond à une action du contrôleur
        if(Tools::getValue('action')) {
            $this->action = Tools::getValue('action');; // On appelle cette action
        }
    }

    public function run() {
        $action = $this->action.'Action'; // On assigne le nom de l'action
        if (method_exists($this, $action)) {
            return $this->{$action}(); // Si l'action existe on la retourne
        } 
        else {
            return $this->renderPageNotFound(); // Si elle n'existe pas, on retourne la page 404
        }
    }

    public function renderPageNotFound() {
        return $this->render('404.html.twig');
    }

    protected function render ($view, $data = []) {

        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [

            'cache' => false,

        ]);
        $data['session'] = $_SESSION;
        return $twig->render($view, $data);
    }

    protected function error($message) {
        $data = [
            'erreur' => $message
        ];
        $this->render('error', $data);
    }
}
