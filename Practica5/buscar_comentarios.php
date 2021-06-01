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
        $texto = $_POST['busq_com'];

        if($texto != ""){
            $variablesParaTwig['lista_comentarios'] = $database->buscarComentario($texto);
        }
        else{
            $variablesParaTwig['resultado'] = "error";
        }
        
        if(empty($variablesParaTwig['lista_comentarios'])){
            $variablesParaTwig['resultado'] = "error";
        }
    }
  
    

    echo $twig->render('lista_comentarios.html', $variablesParaTwig);
?>