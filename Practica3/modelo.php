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
           Devuelve un array con comentarios cada uno con: autor, comentario, fecha */
        public function getComentariosEvento($idEv){
            $consulta = "SELECT * FROM Comentario WHERE evento=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idEv);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $comentario = array('autor' => 'Anonimo', 'comentario' => 'viva el rol', 'fecha' => 'nunca');

            $lista_comentarios = array();
            
            while($row=$res->fetch_assoc()){
                $comentario = array('autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha']);
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
    }

   



?>