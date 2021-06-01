// Funcion para mostrar los datos
function mostrarEventos(datos){
    $("#listaEventos").fadeIn();
    $("#listaEventos").html(datos);
}

// Funcion para ocultar eventos
function ocultarEventos(){
    $("#listaEventos").fadeOut();
}

// Funcion a hacer cada vez que se pulsa una tecla
function eventoPulsarTecla(){
    // Accedo al campo de input
    var consulta = $(this).val();

    if (consulta != ""){
        // Creo la configuracion de AJAX
        configuracionAJAX = { url: "search.php", method: "POST", data: {consulta: consulta}, success: mostrarEventos };

        // Consulto la base de datos por posibles resultados
        $.ajax(configuracionAJAX);
    }
    else{
        ocultarEventos();
    }

    // Si pulso en un elemento se completa el cuadro
    $(document).on('click', 'li', function(){
        $('#evento').val($(this).text());
        ocultarEventos();
    });
    
}

// Funcion para cargar los datos
function cargarDatos(){
    $('#evento').keyup(eventoPulsarTecla);
}

// Cargar los datos una vez listo el documento
$(document).ready(cargarDatos);