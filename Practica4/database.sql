/* Comandos para la ejecucion del fichero
 mysql -h 127.0.0.1 -P 3306 -u ana -p >>> sibw 
 use SIBW;
 source /home/mapachana/Documentos/database.sql */

 /* Para la obtencion de contraseñas cifradas ir a https://sandbox.onlinephpfunctions.com/
 codigo:
 <?php
        echo  password_hash('sibw', PASSWORD_DEFAULT);
y comprobar la contraseña */


/* Borramos las tablas en caso de estar ya creadas */
DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS Comentario;
DROP TABLE IF EXISTS Evento;
DROP TABLE IF EXISTS PalabrasProhibidas;
DROP TABLE IF EXISTS Usuario;

/* Creamos las tablas */

/* Tabla de Evento */
CREATE TABLE Evento(
  id INT AUTO_INCREMENT,
  titulo VARCHAR(100) NOT NULL,
  lugar VARCHAR(100) NOT NULL,
  descripcion TEXT NOT NULL,
  organizador VARCHAR(100) NOT NULL,
  foto_portada VARCHAR(100) NOT NULL,
  enlace VARCHAR(100),
  fecha DATETIME,
  PRIMARY KEY(id)
);

/* Tabla de Imagenes */
CREATE TABLE Imagenes(
  id INT AUTO_INCREMENT,
  ruta VARCHAR(100),
  evento INT NOT NULL,
  pie VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(evento) REFERENCES Evento(id)
);

/* Tabla de comentarios */
CREATE TABLE Comentario(
  id INT AUTO_INCREMENT,
  evento INT NOT NULL,
  autor VARCHAR(100) NOT NULL,
  comentario VARCHAR(300),
  fecha DATETIME,
  editado BOOLEAN,
  PRIMARY KEY(id),
  FOREIGN KEY(evento) REFERENCES Evento(id)
);

/* Tabla de palabras prohibidas */
CREATE TABLE PalabrasProhibidas(
  palabra VARCHAR(50),
  PRIMARY KEY(palabra)
);

/* Tabla de usuarios */
CREATE TABLE Usuario(
  username VARCHAR(50),
  email VARCHAR(100) UNIQUE NOT NULL,
  passw VARCHAR(100) NOT NULL,
  rol ENUM('registrado', 'moderador', 'gestor', 'superusuario') NOT NULL,
  PRIMARY KEY(username)
);

/* Añadimos algunos elementos por defecto a cada tabla */

INSERT INTO Evento(titulo, lugar, descripcion, organizador, fecha, foto_portada, enlace) VALUES('Partida de DyD','Sótano de Dani','Comenzamos nueva campaña de dyd con Dani como master. Hay pizza! Pasaos por la primera sesion', 'Dani', NOW(), './img/dice.png', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstleyVEVO');
INSERT INTO Evento(titulo, lugar, descripcion, organizador, fecha, foto_portada, enlace) VALUES('Partida de Vampiro','Discord','Nos acercamos al final de la campaña de vampiro la mascarada, la proxima sesion va a ser intensa', 'Greevilr', NOW(), './img/dice2.png', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstleyVEVO');
INSERT INTO Evento(titulo, lugar, descripcion, organizador, fecha, foto_portada) VALUES('Nuevo rol','Discord','Abrimos campaña de vampiro!! Hay vacantes, asistid a la sesion 0 para ver si os interesa', 'Santi', NOW(), './img/anya.png');

INSERT INTO Imagenes(ruta, evento, pie) VALUES('./img/dice.png', 1, 'un dado apañao');
INSERT INTO Imagenes(ruta, evento, pie) VALUES('./img/dice3.png', 1, 'un dado rojo');
INSERT INTO Imagenes(ruta, evento, pie) VALUES('./img/dice2.png', 2, 'un dadito rojo');
INSERT INTO Imagenes(ruta, evento, pie) VALUES('./img/myryama.png', 2, 'Myriam y Yama');
INSERT INTO Imagenes(ruta, evento, pie) VALUES('./img/anya.png', 3, 'Anya, Lasombra');

INSERT INTO Comentario(evento, autor, comentario, fecha, editado) VALUES(1, 'Pipe', 'oleee', NOW(), false);
INSERT INTO Comentario(evento, autor, comentario, fecha, editado) VALUES(2, 'Blue', 'vamos a morir', NOW(), false);
INSERT INTO Comentario(evento, autor, comentario, fecha, editado) VALUES(2, 'Nalli', 'Ñam ñam', NOW(), false);

INSERT INTO PalabrasProhibidas(palabra) VALUES('caca');
INSERT INTO PalabrasProhibidas(palabra) VALUES('uwu');
INSERT INTO PalabrasProhibidas(palabra) VALUES('tonto');
INSERT INTO PalabrasProhibidas(palabra) VALUES('idiota');
INSERT INTO PalabrasProhibidas(palabra) VALUES('hatsunemiku');

/* Contraseña sibw */
INSERT INTO Usuario(email, username, passw, rol) VALUES ('ana@ugr.es', 'ana', '$2y$10$kQZF8UnXpwjbkjW5HLMUdejyiGW7NVOEO3ebPyzXWLnPhq0fySEvW', 'superusuario');
/* Contraseña cthulhu */
INSERT INTO Usuario(email, username, passw, rol) VALUES ('greevil@ugr.es', 'greevil', '$2y$10$ICJhbYj7Msik5z98P8yrROp5JCG.JCT7YHBeK3ZJ1DCl3iNfLz.ba', 'moderador');
/* Contraseña vampiro */
INSERT INTO Usuario(email, username, passw, rol) VALUES ('blue@ugr.es', 'blue', '$2y$10$L83GeRza9pY7lkGt8R9DN.6ulJ0CVBanxkXudTLnWfu3Ptqij1Ypa', 'registrado');
/* Contraseña vampiro */
INSERT INTO Usuario(email, username, passw, rol) VALUES ('nalli@ugr.es', 'nalli', '$2y$10$L83GeRza9pY7lkGt8R9DN.6ulJ0CVBanxkXudTLnWfu3Ptqij1Ypa', 'gestor');
/* Contraseña vampiro */
INSERT INTO Usuario(email, username, passw, rol) VALUES ('aaa@ugr.es', 'aaa', '$2y$10$L83GeRza9pY7lkGt8R9DN.6ulJ0CVBanxkXudTLnWfu3Ptqij1Ypa', 'superusuario');