/* Función para mostrar y esconder la barra de comentarios en un evento*/
function ver_comentarios(){
    var barra = document.getElementById("apartado-comentarios");
    barra.classList.toggle("barra-comentarios-activa");
}

document.getElementById("boton-comentarios").onclick = ver_comentarios;

/* Función para enviar un comentario */

function submit_comentario(){
    var nombre = document.getElementById("nombre");
    var email = document.getElementById("email");
    var texto = document.getElementById("texto-comentario");

    var campos_rellenos = true;
    
    var fecha = Date();
    var regex_correo = /^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/; // Expresión regular con la que comparar el correo

    if (nombre.value == ""){
        document.getElementById("error-modal").innerHTML = "El nombre no debe ser vacío";
        document.getElementById("myModal").style.display = "block";

        campos_rellenos = false;
    }

    if (! regex_correo.test(email.value)){
        document.getElementById("error-modal").innerHTML = "El email no es válido";
        document.getElementById("myModal").style.display = "block";

        campos_rellenos = false;
    }

    if (texto.value == ""){
        document.getElementById("error-modal").innerHTML = "El texto no debe ser vacío";
        document.getElementById("myModal").style.display = "block";

        campos_rellenos = false;
    }

    if (campos_rellenos){
        var m = new Date();
        var dateString = m.getFullYear() +"-"+ (m.getMonth()+1) +"-"+ m.getDate() + " " + m.getHours() + ":" + m.getMinutes() + ":" + m.getSeconds();

        document.getElementById("seccion-comentarios").insertAdjacentHTML("beforeend", "<div class=\"comentario\">" + "<h4>" + nombre.value + " " + dateString + "</h4>" + "<p>" + texto.value + "</p>" + "</div>");
    }
}

document.getElementById("enviar-comentario").onclick = submit_comentario;

/* Funcion para corregir palabras */

function reemplazar_palabras(){

    var i;
    var palabras = [];
    var palabras_corregidas = [];

    // Creo el array de palabras corregidas con la longitud necesaria
    for(var j = 0; j < palabras_prohibidas.length; j++)
        palabras_corregidas[j] = "";

    // Creo las palabras prohibidas con sintaxis para el replace y añado los asteriscos a las corregidas
    for(i = 0; i < palabras_prohibidas.length; i++){
        palabras.push(new RegExp(palabras_prohibidas[i], 'g'));
        for(var j = 0; j < palabras_prohibidas[i].length; j++){
            palabras_corregidas[i] = palabras_corregidas[i].concat("*");
        }
    }

    var texto = document.getElementById("texto-comentario").value;

    var texto_corregido = texto;

    var i;
    for (i = 0; i < palabras.length; i++){
        texto_corregido = texto_corregido.replace(palabras[i], palabras_corregidas[i]);
    }

    document.getElementById("texto-comentario").value = texto_corregido;
}

document.getElementById("texto-comentario").onchange = reemplazar_palabras;
document.getElementById("texto-comentario").onkeypress = reemplazar_palabras;

/* Funciones del diálogo modal */

// When the user clicks on <span> (x), close the modal
document.getElementsByClassName("close")[0].onclick = function() {
    document.getElementById("myModal").style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == document.getElementById("myModal")) {
    document.getElementById("myModal").style.display = "none";
  }
}