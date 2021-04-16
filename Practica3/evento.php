<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $nombreEvento = "Nombre por defecto";
    $fechaEvento = "Fecha por defecto"; 

    if($_GET['ev'] == 1){
        $nombreEvento = "Nombre 1";
        $fechaEvento = "Fecha 1";
    }
    else{
        $nombreEvento = "Nombre 2";
        $fechaEvento = "Fecha 2";
    }

    echo $twig->render('evento.html', ['nombre' => $nombreEvento, 'fecha' => $fechaEvento]);
?>
