$(document).ready(function() {
    // Hacer invisible el campo de resultados al inicio
    $("#resultado_empresa").css("visibility", "hidden");

    // Evento al cambiar el valor del input de ID de empresa
    $('#id_empresa').on('input', function() {
        var idEmpresa = $(this).val();
        if (idEmpresa.trim() === '') {
            // Si el campo de búsqueda está vacío, ocultar el campo de resultados y el botón de eliminación
            $("#resultado_empresa").empty().css("visibility", "hidden");
            $("#clear_search").hide();
        } else {
            // Validar que solo se ingresen números
            if (!/^\d+$/.test(idEmpresa)) {
                $(this).val(''); // Limpiar el campo si se ingresan letras o caracteres especiales
                return;
            }
            obtener_registro(idEmpresa);
            // Mostrar el botón de eliminación
            $("#clear_search").show();
        }
    });

    // Evento para borrar el texto del campo de búsqueda al hacer clic en el botón de eliminación
    $('#clear_search').click(function() {
        $('#id_empresa').val('');
        $('#id_empresa').prop('readonly', false); // Hacer que el campo de búsqueda sea editable nuevamente
        // Ocultar el botón de eliminación
        $(this).hide();
        // Limpiar y ocultar los resultados
        $("#resultado_empresa").empty().css("visibility", "hidden");
    });

    // Función para obtener los registros según el ID de empresa
    function obtener_registro(idEmpresa) {
        $.ajax({
            url: '../controller/registrarVoto.php',
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

    // Evento al hacer clic en un resultado de la lista
    $(document).on('click', '#resultado_empresa li', function() {
        if ($(this).text() !== "No se encontró la empresa con el ID proporcionado.") {
            var selectedText = $(this).text(); // Obtener el texto del elemento clicado
            $('#id_empresa').val(selectedText); // Colocar el texto en el campo de búsqueda
            $("#resultado_empresa").empty().css("visibility", "hidden"); // Limpiar los resultados y ocultar el campo de resultados
            $('#id_empresa').prop('readonly', true); // Hacer que el campo de búsqueda sea de solo lectura
            $("#clear_search").show(); // Mostrar el botón de eliminación

            // Cambiar color de fondo y letras
            $(this).addClass('selected');
        }
    });

    // Evento al pasar el cursor sobre un resultado de la lista
    $(document).on('mouseenter', '#resultado_empresa li', function() {
        if ($(this).text() !== "No se encontró la empresa con el ID proporcionado.") {
            $(this).addClass('selected');
        }
    });

    // Evento al retirar el cursor del resultado de la lista
    $(document).on('mouseleave', '#resultado_empresa li', function() {
        if ($(this).text() !== "No se encontró la empresa con el ID proporcionado.") {
            $(this).removeClass('selected');
        }
    });

    // Evento al hacer clic en el botón "Registrar voto"
    $('#registrar_voto_btn').click(function() {
        var idEmpresa = $("#id_empresa").val();
        var presentacion = $("#subject_input").val();

        // Validar si el campo de búsqueda contiene al menos una letra
        if (!/[a-zA-Z]/.test(idEmpresa.trim())) {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Debe seleccionar la empresa',
                didClose: () => {
                    // No hacer nada después de cerrar la alerta
                }
            });
            return; // Detener la ejecución de la función si no se cumple la validación
        }

        // Validar si no se ha seleccionado ninguna opción en el select
        if (!presentacion) {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Debe seleccionar al presente',
                didClose: () => {
                    // No hacer nada después de cerrar la alerta
                }
            });
            return; // Detener la ejecución de la función si no se cumple la validación
        }

        // Enviar datos al controlador PHP para registrar el voto
        $.ajax({
            type: "POST",
            url: "../controller/registrarVoto.php", // Reemplazar con la ruta correcta a tu controlador PHP
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
