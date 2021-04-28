<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();

    $lista_eventos = $database->getListaEventos();

    echo $twig->render('index.html', ['lista_eventos' => $lista_eventos]);
?>