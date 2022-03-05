<?php
namespace App;

use Utils\Tools;

session_start();

require 'vendor/autoload.php';

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
        $nom_fichier = 'controllers/'.$nom_classe.'Controller.php';
        $nom_classe = $nom_controller.'Controller';
        // Si le fichier existe, on l'inclut et on instancie un objet de cette classe
    
    if (file_exists($nom_fichier)) {
        $nom_classe = '\\Controllers\\'.$nom_classe;
        $controller = new $nom_classe();
        echo $controller->run();
    }
    else {
        header('Location: ?controller=home&action=error404');
        exit;
        // exit ("Error 404: not found !");
    }
