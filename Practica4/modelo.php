<?php

    class Database{
        private static $instance;
        private $mysqli;
    

        /* Constructor de la clase para crear el objeto mysqli */
        private function __construct(){
            $this->$mysqli = new mysqli("mysql", "ana", "sibw", "SIBW");
            if ($mysqli->connect_errno) {
            echo ("Fallo al conectar: " . $mysqli->connect_error);
            }

            $this->$mysqli->set_charset("utf8");
        }

        /* Obtener instancia de la base de datos para no hacer 50 conexiones */
        public static function getInstance(){
            if(!self::$instance instanceof self){
                self::$instance = new self();
            }
        
            return self::$instance;
        }

        /* Funcion para obtener un evento por su identificador 
           Devuelve un array con: id, titulo, lugar, descripcion, organizador, fecha, enlace */
        public function getEvento($idEv){
            $consulta = "SELECT * FROM Evento WHERE id=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idEv);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $evento = array('id' => '-1', 'titulo' => '¡Ups! Este evento no existe :(', 'lugar' => 'XXX', 'descripcion' => 'XXX', 'organizador' => 'XXX', 'fecha' => 'XXX', 'enlace' => '');
            
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                
                $evento = array('id' => $row['id'], 'titulo' => $row['titulo'], 'lugar' => $row['lugar'], 'descripcion' => $row['descripcion'], 'organizador' => $row['organizador'], 'fecha' => $row['fecha'], 'enlace' => $row['enlace']);
            }
            
            return $evento;
        }

        /* Funcion para obtener las fotos de un evento
           Devuelve un array con imagenes cada una con: ruta, pie */
        public function getFotosEvento($idEv){
            $consulta = "SELECT * FROM Imagenes WHERE evento=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idEv);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $imagen = array('ruta' => '../img/dice.png', 'pie' => 'Pie de foto');

            $lista_imagenes = array();
            
            while($row=$res->fetch_assoc()){
                $imagen = array('ruta' => $row['ruta'], 'pie' => $row['pie']);
                $lista_imagenes[] = $imagen;
            }
            
            return $lista_imagenes;
        }

        /* Funcion para obtener los comentarios de un evento 
           Devuelve un array con comentarios cada uno con: id, autor, comentario, fecha */
        public function getComentariosEvento($idEv){
            $consulta = "SELECT * FROM Comentario WHERE evento=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idEv);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            // $comentario = array('autor' => 'Anonimo', 'comentario' => 'viva el rol', 'fecha' => 'nunca');

            $lista_comentarios = array();
            
            while($row=$res->fetch_assoc()){
                $comentario = array('id' => $row['id'], 'autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'editado' => $row['editado']);
                $lista_comentarios[] = $comentario;
            }
            
            return $lista_comentarios;
        }

        /* Funcion para obtener un comentario por su identificador 
           Devuelve un array con: id, autor, comentario, fecha, evento  */
           public function getComentario($idCm){
            $consulta = "SELECT * FROM Comentario WHERE id=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idCm);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $comentario = array('id' => 'xx', 'autor' => 'xx', 'comentario' => 'xx', 'fecha' => 'xx', 'evento' => '-1');
            
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                
                $comentario = array('id' => $row['id'], 'autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'evento' => $row['evento'], 'editado' => $row['editado']);
            }
            
            return $comentario;
        }

        /* Funcion para actualizar un comentario por su identificador
           Devuelve el comentario actualizado */
        public function actualizarComentario($idCm, $texto){
            $consulta = "UPDATE Comentario SET comentario=?, editado=true WHERE id=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("si", $texto, $idCm);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
            }else{
                $row = 0;
            }

            return $row;
        }

        /* Funcion para borrar un comentario por su identificador
           */
        public function borrarComentario($idCm){
            $consulta = "DELETE FROM Comentario WHERE id=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i", $idCm);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        }

        /* Funcion para obtener la lista de comentarios
           Devuelve un array con eventos cada uno con: id, titulo, foto_portada */
           public function getListaComentarios(){
            $consulta = "SELECT * FROM Comentario";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            //$evento = array('id' => '-1', 'titulo' => 'Evento', 'foto_portada' => './img/dice.png');

            $lista_comentarios = array();
            
            /* Para cada evento obtenido obtengo sus fotos y pongo la primera en la portada */
            while($row=$res->fetch_assoc()){
                $comentario = array('id' => $row['id'], 'autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'evento' => $row['evento'], 'editado' => $row['editado']);  
                $lista_comentarios[] = $comentario;
            }
            
            return $lista_comentarios;
        }

        /* Funcion para obtener la lista de eventos 
           Devuelve un array con eventos cada uno con: id, titulo, foto_portada */
        public function getListaEventos(){
            $consulta = "SELECT id, titulo, foto_portada FROM Evento";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $evento = array('id' => '-1', 'titulo' => 'Evento', 'foto_portada' => './img/dice.png');

            $lista_eventos = array();
            
            /* Para cada evento obtenido obtengo sus fotos y pongo la primera en la portada */
            while($row=$res->fetch_assoc()){
                $evento = array('id' => $row['id'], 'titulo' => $row['titulo'], 'foto_portada' => $row['foto_portada']);  
                $lista_eventos[] = $evento;
            }
            
            return $lista_eventos;
        }

        /* Funcion para obtener las palabras prohibidas
           Devuelve un array con de palabras */
        public function getPalabrasProhibidas(){
            $consulta = "SELECT * FROM PalabrasProhibidas";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $palabra = array('palabra' => 'xxx');

            $lista_palabras = array();
            
            while($row=$res->fetch_assoc()){
                $palabra = array('palabra' => $row['palabra']);
                $lista_palabras[] = $palabra;
            }
            
            return $lista_palabras;
        }

        /* Funcion para comprobar si existe un usuario con el nombre de usuario y contraseña dada
           Devuelve true o false */
        public function checkLogin($nick, $pass) {
            $consulta = "SELECT * FROM Usuario WHERE username=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("s",$nick);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
            
            while($row=$res->fetch_assoc()){
                if (password_verify($pass, $row['passw'] )) {
                    return true;
                }
            }
            
            return false;
          }

          /* Funcion para obtener un usuario por su username */
          function getUser($nick) {
            $consulta = "SELECT * FROM Usuario WHERE username=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("s",$nick);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
            }else{
                $row = 0;
            }

            return $row;
          }

          /* Funcion para actualizar un usuario por su username */
          function actualizarUser($actuser, $nick, $email, $pass) {
            $consulta = "UPDATE Usuario SET username=?, email=?, passw=? WHERE username=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("ssss", $nick, $email, $pass, $actuser);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
            }else{
                $row = 0;
            }

            return $row;
          }

          /* Funcion para comprobar si se puede modificar un rol de usuario verificando que siempre hay un superusuario
             Devuelve true si se puede y false si no */
        function quitarSuperusuario($username) {
            $consulta = "SELECT rol FROM Usuario WHERE username=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();

            $sepuede = true;

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
                if($row['rol'] == 'superusuario'){
                    $consulta2 = "SELECT * FROM Usuario WHERE rol='superusuario'";
                    /* stmt representa una consulta lista */
                    $stmt2 = $this->$mysqli->prepare($consulta2);
                    $stmt2->execute();
                    $res2=$stmt2->get_result();
                    $stmt2->close();

                    if ($res2->num_rows < 2){
                        $sepuede = false;
                    }
                }
            }
            else{
                $row = 0;
                $sepuede = false;
            }

            return $sepuede;
        }

        /* Funcion para actualizar el rol de un usuario por su username */
        function actualizarRol($username, $rol) {
            $consulta = "UPDATE Usuario SET rol=? WHERE username=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("ss", $rol, $username);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
            }else{
                $row = 0;
            }

            return $row;
          }
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
   



?>