/* mysql -h 127.0.0.1 -P 3306 -u ana -p >> sibw */
/* use SIBW; */
/* source /home/Documentos/archivo.sql */

/* Borramos las tablas en caso de estar ya creadas */


DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS Comentario;
DROP TABLE IF EXISTS Evento;
DROP TABLE IF EXISTS PalabrasProhibidas;

/* Creamos las tablas */

/* Tabla de Evento */
CREATE TABLE Evento(
  id INT AUTO_INCREMENT,
  titulo VARCHAR(100) NOT NULL,
  lugar VARCHAR(100) NOT NULL,
  descripcion TEXT NOT NULL,
  organizador VARCHAR(100) NOT NULL,
  fecha DATE,
  PRIMARY KEY(id)
);

/* Tabla de Imagenes */
CREATE TABLE Imagenes(
  id VARCHAR(100),
  evento INT NOT NULL,
  extImagen VARCHAR(10) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(evento) REFERENCES Evento(id)
);

/* Tabla de comentarios */

CREATE TABLE Comentario(
  id INT AUTO_INCREMENT,
  evento INT NOT NULL,
  autor VARCHAR(100) NOT NULL,
  comentario VARCHAR(300),
  fecha DATE,
  PRIMARY KEY(id),
  FOREIGN KEY(evento) REFERENCES Evento(id)
);

CREATE TABLE PalabrasProhibidas(
  palabra VARCHAR(50),
  PRIMARY KEY(palabra)
);

/* Añadimos algunos elementos por defecto */

INSERT INTO Evento(titulo, lugar, descripcion, organizador, fecha) VALUES('Partida de DyD','Sotano de Dani','Comenzamos nueva campaña de dyd con Dani como master. Hay pizza!', 'Dani', NOW());
INSERT INTO Evento(titulo, lugar, descripcion, organizador, fecha) VALUES('Partida de Vampiro','Discord','Nos acercamos al final de la campaña de vampiro la mascarada', 'Greevilr', NOW());



INSERT INTO Imagenes(id, evento, extImagen) VALUES('../img/dice', 1,'png');
INSERT INTO Imagenes(id, evento, extImagen) VALUES('../img/dice2', 2,'png');

INSERT INTO Comentario(evento, autor, comentario, fecha) VALUES(1, 'Pipe', 'oleee', NOW());
INSERT INTO Comentario(evento, autor, comentario, fecha) VALUES(2, 'Blue', 'vamos a morir', NOW());

INSERT INTO PalabrasProhibidas(palabra) VALUES('caca');
INSERT INTO PalabrasProhibidas(palabra) VALUES('uwu');
INSERT INTO PalabrasProhibidas(palabra) VALUES('tonto');
INSERT INTO PalabrasProhibidas(palabra) VALUES('idiota');
INSERT INTO PalabrasProhibidas(palabra) VALUES('hatsunemiku');
