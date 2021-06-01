<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
    $variablesParaTwig = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nick = $_POST['nick'];
        $email = $_POST['email'];
        $pass = $_POST['contraseña'];
      
       
        session_start();

        $res = $database->addUser($nick, $email, $pass);
        if($res){
          $variablesParaTwig['resultado'] = "insertado";
          $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
          header("Location: index.php");
        }
        else{
            $variablesParaTwig['resultado'] = "error";
        }
      }
      
      echo $twig->render('registrarse.html', $variablesParaTwig);
    ?>