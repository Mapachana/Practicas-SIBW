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
    
    var fecha = Date();
    var regex_correo = /^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/; // Expresión regular con la que comparar el correo

    if (nombre.value == ""){
        document.getElementById("error-modal").innerHTML = "El nombre no debe ser vacío";
        document.getElementById("myModal").style.display = "block";
    }

    if (! regex_correo.test(email.value)){
        document.getElementById("error-modal").innerHTML = "El email no es válido " + email.value;
        document.getElementById("myModal").style.display = "block";
    }

    if (texto.value == ""){
        document.getElementById("error-modal").innerHTML = "El texto no debe ser vacío";
        document.getElementById("myModal").style.display = "block";
    }
}

document.getElementById("enviar-comentario").onclick = submit_comentario;

/* Funciones del diálogo modal */
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}