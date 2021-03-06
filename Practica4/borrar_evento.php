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

    if(isset($_GET['ev']) && is_numeric($_GET['ev']) ){
        $idEV = $_GET['ev'];
      
        $variablesParaTwig['evento'] = $database->getEvento($idEV);
    }
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $database->borrarEvento($idEV);

        header("Location: index.php");
    }

      echo $twig->render('borrar_evento.html', $variablesParaTwig);
    ?>