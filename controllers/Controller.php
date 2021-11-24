<?php

abstract class Controller
{

    // Force les classes filles à définir cette méthode
    abstract public function default();

    public function __construct() {
        // On teste si un paramètre action existe et s'il correspond à une action du contrôleur
        if(isset($_GET['action']) and method_exists($this, $_GET['action'])) {
            $action = $_GET['action'];
            $this->$action(); // On appelle cette action
        }
        else {
            $this->default(); // Sinon on appelle l'action par défaut
        }
    }


    protected function render ($vue, $data = []) {
        
        // On extrait les données à afficher
        extract ($data);

        // On teste si la vue existe
        $file_name = "Views/".$vue.'.php';

        // On fait appel au template si la vue existe
        if (file_exists($file_name))
        {
            require('Views/gestion/template.php') ;
        }
        else
        {
            // Sinon on affiche la page d'erreur
            $this->error("La vue n’existe pas !") ;
        }

    }

    protected function error($message) {
        $data = [
            'erreur' => $message
        ];
        $this->render('error', $data);
        die(); // Pour terminer le script vu qu'il y a une erreur
    }
}