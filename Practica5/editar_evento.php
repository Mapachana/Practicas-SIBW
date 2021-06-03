<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
  
    session_start();

    if(isset($_GET['ev']) && is_numeric($_GET['ev']) ){
      $idEV = $_GET['ev'];
    }
    else{
      $idEV = -1;
    }

    $variablesParaTwig = [];

    $variablesParaTwig['evento'] = $database->getEvento($idEV);
    $variablesParaTwig['lista_imagenes'] = $database->getFotosEvento($idEV);
    
    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }
    if($variablesParaTwig['user']['rol'] != 'gestor' && $variablesParaTwig['user']['rol'] != 'superusuario'){
      header("Location: index.php");
  }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $titulo = $_POST['titulo'];
      $organizador = $_POST['organizador'];
      $fecha = $_POST['fecha'];
      $lugar = $_POST['lugar'];
      $descripcion = $_POST['descr'];
      $enlace = $_POST['enlace'];
      $etiquetas = $_POST['etiquetas'];
      $publicado = $_POST['publicado'];
      
      // Cargo imagen principal
      if(isset($_FILES['imagen'])){
          $errors= array();
          $file_name = $_FILES['imagen']['name'];
          $file_size = $_FILES['imagen']['size'];
          $file_tmp = $_FILES['imagen']['tmp_name'];
          $file_type = $_FILES['imagen']['type'];
          $file_ext = strtolower(end(explode('.',$_FILES['imagen']['name'])));
          
          $extensions= array("jpeg","jpg","png");
          
          if (in_array($file_ext,$extensions) === false){
            $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
          }
          
          if ($file_size > 2097152){
            $errors[] = 'Tamaño del fichero demasiado grande';
          }
          
          if (empty($errors)==true) {
            move_uploaded_file($file_tmp, "img/" . $file_name);
            
            $variablesParaTwig['imagen'] = "img/" . $file_name;

            $res = $database->updateEvento($idEV, $titulo, $organizador, $fecha, $lugar, $descripcion, $enlace, $etiquetas, $file_name, $publicado);
            if($res){
                $variablesParaTwig['resultado'] = "insertado";
            }
            else{
                $variablesParaTwig['resultado'] = "error";
            }
          }
          
          if (sizeof($errors) > 0) {
            $variablesParaTwig['errores'] = $errors;
          }
      }

      // Cargo imagenes del evento
      if(isset($_FILES['imagenes'])){
          $errors2= array();
          $total_ficheros = count($_FILES['imagenes']['name']);
          $database->borrarImagenesEvento($idEV);

          for($i = 0; $i < $total_ficheros; $i++){
            $file_name2 = $_FILES['imagenes']['name'][$i];
            $file_size2 = $_FILES['imagenes']['size'][$i];
            $file_tmp2 = $_FILES['imagenes']['tmp_name'][$i];
            $file_type2 = $_FILES['imagenes']['type'][$i];
            $file_ext2 = strtolower(end(explode('.',$_FILES['imagenes']['name'][$i])));
            
            $extensions= array("jpeg","jpg","png");
            
            if (in_array($file_ext2,$extensions) === false){
              $errors2[] = "Extensión no permitida, elige una imagen JPEG o PNG. B";
            }
            
            if ($file_size2 > 2097152){
              $errors2[] = 'Tamaño del fichero demasiado grande';
            }
            
            if (empty($errors2)==true) {
              move_uploaded_file($file_tmp2, "img/" . $file_name2);

              $database->addImagenEvento($idEV, $file_name2);
            }
            
            if (sizeof($errors2) > 0) {
              $variablesParaTwig['errores'] = $errors2;
            }
          }
          
      }
    }


      echo $twig->render('editar_evento.html', $variablesParaTwig);
    ?>