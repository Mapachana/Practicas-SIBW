<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if(isset($_GET['ev']) && is_numeric($_GET['ev']) ){
        $idEV = $_GET['ev'];
    }
    else{
        $idEV = -1;
    }

    $variablesParaTwig = [];

    $database=Database::getInstance();
  
    session_start();
    
    $variablesParaTwig['evento'] = $database->getEvento($idEV);

    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }
     // Si el evento no está publicado y no soy gestor o superusuario no puedo verlo
    if($variablesParaTwig['evento']['publicado'] != '1' && $variablesParaTwig['user']['rol'] != 'gestor' && $variablesParaTwig['user']['rol'] != 'superusuario'){
        $idEV = -1;
        $variablesParaTwig['evento'] = $database->getEvento($idEV);
    }


    $variablesParaTwig['lista_imagenes'] = $database->getFotosEvento($idEV);
    $variablesParaTwig['lista_comentarios'] = $database->getComentariosEvento($idEV);
    $variablesParaTwig['lista_palabras'] = $database->getPalabrasProhibidas();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $texto = $_POST['texto'];

        if($texto != ""){
            $database->addComentario($idEV, $variablesParaTwig['user']['username'], $variablesParaTwig['user']['email'], $texto);
            header("Location: evento.php?ev=$idEV");
        }
        
    }


    echo $twig->render('evento.html', $variablesParaTwig);
?>
