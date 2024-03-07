$(document).ready(function() {
    // Hacer invisible el campo de resultados al inicio
    $("#resultado_empresa").css("visibility", "hidden");

    // Evento al cambiar el valor del input de ID de empresa
    $('#id_empresa').on('input', function() {
        var idEmpresa = $(this).val();
        if (idEmpresa.trim() === '') {
            // Si el campo de búsqueda está vacío, ocultar el campo de resultados
            $("#resultado_empresa").empty().css("visibility", "hidden");
        } else {
            obtener_registro(idEmpresa);
        }
    });

    // Función para obtener los registros según el ID de empresa
    function obtener_registro(idEmpresa) {
        $.ajax({
            url: 'http://localhost/votos/controller/votos.php',
            type: 'POST',
            dataType: 'html',
            data: {
                id_empresa: idEmpresa
            },
        })
        .done(function(resultado) {
            if (resultado.trim() === '') {
                $("#resultado_empresa").empty().css("visibility", "hidden"); // Si no hay resultados, ocultar el campo de resultados
            } else {
                $("#resultado_empresa").html(resultado).css("visibility", "visible"); // Mostrar el campo de resultados
            }
        })
        .fail(function() {
            $("#resultado_empresa").empty().css("visibility", "hidden"); // Manejo de errores: ocultar el campo de resultados en caso de fallo
        });
    }

    // Evento al hacer clic en el botón "Registrar voto"
    $('#registrar_voto_btn').click(function() {
        var idEmpresa = $("#id_empresa").val();
        var presentacion = $("#subject_input").val();

        // Enviar datos al controlador PHP para registrar el voto
        $.ajax({
            type: "POST",
            url: "http://localhost/votos/controller/votos.php", // Reemplazar con la ruta correcta a tu controlador PHP
            data: {
                id_empresa: idEmpresa,
                subject: presentacion
            },
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: responseData.message,
                        didClose: () => {
                            location.reload(); // Recargar la página después de cerrar el Sweet Alert
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: responseData.message,
                        didClose: () => {
                            location.reload(); // Recargar la página después de cerrar el Sweet Alert
                        }
                    });
                }
            }
        });
    });
});




