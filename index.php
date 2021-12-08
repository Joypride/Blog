<?php

require 'vendor/autoload.php';

require_once('Models/Model.php') ; // Inclusion du modèle
require_once('Controllers/Controller.php') ;

$controller_default = "Home"; // Nom du contrôleur par défaut

    if (isset($_GET['controller'])) {
        $nom_controller = ucfirst($_GET['controller']);
    }
    else {
        $nom_controller = $controller_default;
    }
        // On détermine le nom de la classe du contrôleur
        $nom_classe = $nom_controller;
        // On détermine le nom du fichier contenant la définition du contrôleur
        $nom_fichier = 'controllers/Controller'.$nom_classe.'.php';
        // Si le fichier existe, on l'inclut et on instancie un objet de cette classe
    
    if (file_exists($nom_fichier)) {
        require_once($nom_fichier);
        $controller = new $nom_classe();
        echo $controller->run();
    }
    else {
        exit ("Error 404: not found !");
    }
 