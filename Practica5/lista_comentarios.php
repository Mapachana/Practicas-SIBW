<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();

    $variablesParaTwig = [];

    $variablesParaTwig['lista_comentarios'] = $database->getListaComentarios();
  
    session_start();
    
    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }
    if($variablesParaTwig['user']['rol'] != 'moderador' && $variablesParaTwig['user']['rol'] != 'gestor' && $variablesParaTwig['user']['rol'] != 'superusuario'){
        header("Location: index.php");
    }


    echo $twig->render('lista_comentarios.html', $variablesParaTwig);
?>