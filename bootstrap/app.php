<?php

/*
|-----------------------------
| Register The Auto Loader
|-----------------------------
|
| Composer automatically generated class loader 
|
*/
require_once 'vendor/autoload.php';

require 'Imager.php';

/**
 * Init twig package
 */
function render($view,$data){
    $loader=new \Twig\Loader\FilesystemLoader('resources/views/');

    if(!$loader->exists($view)){ $view='errors/404.twig';}

    $twig = new \Twig\Environment($loader, []);
    try {
        echo $twig->render($view, $data);
    } catch (\Twig\Error\LoaderError $e) {
        var_dump($e);
    } catch (\Twig\Error\RuntimeError $e) {
        var_dump($e);

    } catch (\Twig\Error\SyntaxError $e) {
        var_dump($e);
    }
}

require_once 'helpers.php';

require_once 'db/init.php';
