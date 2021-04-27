<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $nombreEvento = "Nombre por defecto";
    $fechaEvento = "Fecha por defecto";

    if(isset($_GET['ev'])){
        $idEV = $_GET['ev'];
    }
    else{
        $idEV = -1;
    }

    echo $twig->render('evento.html', ['nombre' => $nombreEvento, 'fecha' => $fechaEvento]);
?>
