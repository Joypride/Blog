<?php

require 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new Twig\Environment($loader, [

    'cache' => false,

]);

echo $twig->render('index.html.twig');

require_once('Models/Model.php') ; // Inclusion du modèle
require_once('Controllers/Controller.php') ;

$controllers = ["home", "post", "user", "comment"]; // Liste des contrôleurs
$controller_default = "home"; // Nom du contrôleur par défaut

    if (isset($_GET['controller']) and in_array($_GET['controller'], $controllers)) {
        $nom_controller = $_GET['controller'];
    }
    else {
        $nom_controller = $controller_default;
    }
        // On détermine le nom de la classe du contrôleur
        $nom_classe = 'Controller_'.$nom_controller;
        // On détermine le nom du fichier contenant la définition du contrôleur
        $nom_fichier = 'Controllers/'.$nom_classe.'.php';
        // Si le fichier existe, on l'inclut et on instancie un objet de cette classe
    
    if (file_exists($nom_fichier)) {
        require_once($nom_fichier);
        $controller = new $nom_classe();
    }
    else {
        exit ("Error 404: not found !");
    }
 