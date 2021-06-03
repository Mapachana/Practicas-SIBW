// Funcion para mostrar los datos
function mostrarEventos(datos){
    $("#listaEventos").fadeIn();
    $("#listaEventos").html(datos);
}

// Funcion para ocultar eventos
function ocultarEventos(){
    $("#listaEventos").fadeOut();
}

// Cargar los datos una vez listo el documento
$(document).ready(function(){
    $('#evento').keyup(function(){
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
    });
});