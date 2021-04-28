<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if(isset($_GET['ev'])){
        $idEV = $_GET['ev'];
    }
    else{
        $idEV = -1;
    }

    $database=Database::getInstance();

    $evento = $database->getEvento($idEV);
    $lista_imagenes = $database->getFotosEvento($idEV);
    $lista_comentarios = $database->getComentariosEvento($idEV);
    $lista_palabras = $database->getPalabrasProhibidas();

    echo $twig->render('evento.html', ['idEvento' => $idEV, 'evento' => $evento, 'lista_imagenes' => $lista_imagenes, 'lista_comentarios' => $lista_comentarios, 'lista_palabras' => $lista_palabras]);
?>
