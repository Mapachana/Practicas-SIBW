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
    if($variablesParaTwig['user']['rol'] != 'gestor' && $variablesParaTwig['user']['rol'] != 'superusuario'){
        header("Location: index.php");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $texto = $_POST['busq_event'];

        if($texto != ""){
            $variablesParaTwig['lista_eventos'] = $database->buscarEvento($texto);
        }
        else{
            $variablesParaTwig['resultado'] = "error";
        }
        
        
        if(empty($variablesParaTwig['lista_eventos'])){
            $variablesParaTwig['resultado'] = "error";
        }
    }
  
    

    echo $twig->render('lista_eventos.html', $variablesParaTwig);
?>