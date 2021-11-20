<?php

require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');

$twig = new Twig_Environment($loader, [

    'cache' => false,

]);

echo $twig->render('index.html.twig');

?>