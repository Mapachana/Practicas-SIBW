<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nick = $_POST['nick'];
        $pass = $_POST['contraseña'];
      
        if ($database->checkLogin($nick, $pass)) {
          session_start();
          
          $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
        }
        
        header("Location: index.php");
        
        exit();
      }
      
      echo $twig->render('login.html', []);
    ?>