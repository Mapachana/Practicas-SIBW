<?php

  require_once "/usr/local/lib/php/vendor/autoload.php";
  include('modelo.php');

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig   = new \Twig\Environment($loader);

  $database = Database::getInstance();
  $variablesParaTwig = [];

  session_start();
    
  if (isset($_SESSION['nickUsuario'])) {
    $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);

  }
  else{
    $variablesParaTwig['user'] = ['rol' => 'anonimo'];
  }

  if(isset($_POST['consulta'])){
    $variablesParaTwig['lista_eventos'] = $database->consultarEventos($_POST['consulta'], $variablesParaTwig['user']['rol']);
    echo $twig->render("lista.html", $variablesParaTwig);
  }

  if(isset($_GET['prueba'])){
  echo $database->consultarEventos($_GET['prueba']);
  }

?>
