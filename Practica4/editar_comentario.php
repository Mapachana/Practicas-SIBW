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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $texto = $_POST['texto'];

      if ($texto != ""){
        // Actualizo el comentario
        $database->actualizarComentario($idCm, $texto);

        header("Location: evento.php?ev=$evento");
      }
      else{
        $variablesParaTwig['resultado'] = "error";
      }
      
    }

      echo $twig->render('editar_comentario.html', $variablesParaTwig);
    ?>