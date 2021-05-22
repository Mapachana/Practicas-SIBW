<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
  
    session_start();

    $variablesParaTwig = [];
    
    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

    if(isset($_GET['cm']) && is_numeric($_GET['cm']) ){
        $idCm = $_GET['cm'];
      
        $variablesParaTwig['comentario'] = $database->getComentario($idCm);
        $evento = $variablesParaTwig['comentario']['evento'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $database->borrarComentario($idCm);

        header("Location: evento.php?ev=$evento");
    }

      echo $twig->render('borrar_comentario.html', $variablesParaTwig);
    ?>