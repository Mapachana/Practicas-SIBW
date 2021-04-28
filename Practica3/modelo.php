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

        /* Obtener instancia de la base de datos para no hace 50 conexiones */
        public static function getInstance(){
            if(!self::$instance instanceof self){
                self::$instance = new self();
            }
        
            return self::$instance;
        }

        /* Funcion para obtener un evento por su identificador */
        public function getEvento($idEv){
            $consulta = "SELECT * FROM Evento WHERE id=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idEv);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $evento = array('titulo' => 'XXX', 'lugar' => 'YYY', 'descripcion' => 'YYY', 'organizador' => 'YYY', 'fecha' => 'YYY');
            
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                
                $evento = array('titulo' => $row['titulo'], 'lugar' => $row['lugar'], 'descripcion' => $row['descripcion'], 'organizador' => $row['organizador'], 'fecha' => $row['fecha']);
            }
            
            return $evento;
        }

        /* Funcion para obtener las fotos de un evento */
        public function getFotosEvento($idEv){
            $consulta = "SELECT * FROM Imagenes WHERE evento=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idEv);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $imagen = array('ruta' => '../img/dice', 'extension' => '.png', 'pie' => 'Pie de foto');

            $lista_imagenes = array();
            
            while($row=$res->fetch_assoc()){
                $imagen = array('ruta' => $row['ruta'], 'extension' => $row['extImagen'], 'pie' => $row['pie']);
                $lista_imagenes[] = $imagen;
            }
            
            return $lista_imagenes;
        }

        /* Funcion para obtener los comentarios de un evento */
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

        /* Funcion para obtener la lista de eventos */
        public function getListaEventos(){
            $consulta = "SELECT id, titulo FROM Evento";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $evento = array('id' => '-1', 'titulo' => 'Evento', 'ruta' => '../img/dice', 'extension' => '.png');

            $lista_eventos = array();
            
            /* Para cada evento obtenido obtengo sus fotos y pongo la primera en la portada */
            while($row=$res->fetch_assoc()){
                $consulta2 = "SELECT ruta, extImagen FROM Imagenes WHERE evento=?";
                /* stmt representa una consulta lista */
                $stmt2 = $this->$mysqli->prepare($consulta2);
                $idevent = $row['id'];
                $stmt2->bind_param("i",$idevent);
                $stmt2->execute();
                $res2=$stmt2->get_result();
                $stmt2->close();

                if ($res2->num_rows > 0) {
                    $row2 = $res2->fetch_assoc();
                    
                    $evento = array('id' => $row['id'], 'titulo' => $row['titulo'], 'ruta' => $row2['ruta'], 'extension' => $row2['extImagen']);
                }
                else{
                    $evento = array('id' => $row['id'], 'titulo' => $row['titulo'], 'ruta' => '../img/dice', 'extension' => '.png');
                }
            
                
                $lista_eventos[] = $evento;
            }
            
            return $lista_eventos;
        }

        /* Funcion para obtener las palabras prohibidas*/
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