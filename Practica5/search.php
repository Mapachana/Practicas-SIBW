<?php

  require_once "/usr/local/lib/php/vendor/autoload.php";
  include('modelo.php');

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig   = new \Twig\Environment($loader);

  $database = Database::getInstance();

  session_start();
    
    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

    if(isset($_POST['consulta'])){
      $database->consultarEventos($_POST['consulta']);
      //$lista_eventos = $database->consultarEvento($_POST['consulta']);
      //  echo $twig->render("lista_eventos.html", ['lista_eventos' => $lista_eventos]);
    }

    if(isset($_GET['prueba'])){
    echo $database->consultarEventos($_GET['prueba']);
    }

?>
