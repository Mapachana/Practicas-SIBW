<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();

    $variablesParaTwig = [];
  
    session_start();
    
    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nick = $_POST['nick'];
      $email = $_POST['email'];
      $pass = $_POST['contraseña'];

      // Actualizo el user
      $database->actualizarUser($_SESSION['nickUsuario'], $nick, $email, password_hash($pass, PASSWORD_DEFAULT));

      // Actualizo el user
      $variablesParaTwig['user'] = $database->getUser($nick);

    }

      echo $twig->render('perfil.html', $variablesParaTwig);
    ?>