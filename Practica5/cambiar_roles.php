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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = $_POST['username'];
      $rol = $_POST['rol'];

      // Compruebo si al usuario le puedo quitar el rol de superusuario en caso de ser superusuario
    if ($database->quitarSuperusuario($username)){
      $database->actualizarRol($username, $rol);
      header("Location: index.php");
    }
    else{
      $variablesParaTwig['resultado'] = "error";
    } 
    }

      echo $twig->render('cambiar_roles.html', $variablesParaTwig);
    ?>