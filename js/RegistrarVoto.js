$(document).ready(function() {
    // Hacer invisible el campo de resultados al inicio
    $("#resultado_empresa").css("visibility", "hidden");

    // Evento al cambiar el valor del input de ID de empresa
    $('#id_empresa').on('input', function() {
        var idEmpresa = $(this).val();
        if (idEmpresa.trim() === '') {
            // Si el campo de búsqueda está vacío, mostrar los elementos del select y el botón
            $("#resultado_empresa").empty().css("visibility", "hidden");
            $("#subject_input, .contenedor, #registrar_voto_btn").css("visibility", "visible");
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
        // Mostrar los elementos relevantes
        $("#subject_input").css("visibility", "visible");
        $(".contenedor").css("visibility", "visible");
        $("#registrar_voto_btn").css("visibility", "visible");
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
                // Si no hay resultados, ocultar el campo de resultados y mostrar los elementos relevantes
                $("#resultado_empresa").empty().css("visibility", "hidden");
                $("#subject_input, .contenedor, #registrar_voto_btn").css("visibility", "visible");
            } else {
                if (
                    resultado.includes("<li>No se encontró la empresa con el ID proporcionado.</li>") || 
                    resultado.includes("<li>La empresa con el ID proporcionado ya registró su voto.")
                ) {
                    // Si no se encuentra la empresa o ya registró su voto, ocultar los elementos relevantes
                    $("#resultado_empresa").html(resultado).css("visibility", "visible");
                    $("#subject_input, .contenedor, #registrar_voto_btn").css("visibility", "hidden");
                    $("#resultado_empresa li.not-selectable").css("user-select", "none"); // Aplicar estilo a texto
                    $("#resultado_empresa li").removeClass("selectable"); // Quitar la clase "selectable" de los elementos de la lista
                } else {
                    // Mostrar los resultados normales y los elementos relevantes
                    $("#resultado_empresa").html(resultado).css("visibility", "visible");
                    $("#subject_input, .contenedor, #registrar_voto_btn").css("visibility", "visible");
                    $("#resultado_empresa li.not-selectable").css("user-select", "text"); // Restaurar estilo
                    $("#resultado_empresa li").addClass("selectable"); // Agregar la clase "selectable" a los elementos de la lista
                }
            }
        })
        .fail(function() {
            $("#resultado_empresa").empty().css("visibility", "hidden"); // Manejo de errores: ocultar el campo de resultados en caso de fallo
        });
    }

    // Evento al hacer clic en un resultado de la lista
    $(document).on('click', '#resultado_empresa li.selectable', function() {
        var selectedText = $(this).text(); // Obtener el texto del elemento clicado
        $('#id_empresa').val(selectedText); // Colocar el texto en el campo de búsqueda
        $("#resultado_empresa").empty().css("visibility", "hidden"); // Limpiar los resultados y ocultar el campo de resultados
        $('#id_empresa').prop('readonly', true); // Hacer que el campo de búsqueda sea de solo lectura
        $("#clear_search").show(); // Mostrar el botón de eliminación

        // Cambiar color de fondo y letras
        $(this).addClass('selected');

        // Mostrar los elementos relevantes
        $("#subject_input").css("visibility", "visible");
        $(".contenedor").css("visibility", "visible");
        $("#registrar_voto_btn").css("visibility", "visible");
    });

    // Evento al pasar el cursor sobre un resultado de la lista
    $(document).on('mouseenter', '#resultado_empresa li.selectable', function() {
        $(this).addClass('selected');
    });

    // Evento al retirar el cursor del resultado de la lista
    $(document).on('mouseleave', '#resultado_empresa li.selectable', function() {
        $(this).removeClass('selected');
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
                text: 'Debe seleccionar la empresa'
            });
            return; // Detener la ejecución de la función si no se cumple la validación
        }

        // Validar si no se ha seleccionado ninguna opción en el select
        if (!presentacion) {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Debe seleccionar la condición del votante'
            });
            return; // Detener la ejecución de la función si no se cumple la validación
        }

        // Enviar datos al controlador PHP para registrar el voto
        $.ajax({
            type: "POST",
            url: "../controller/registrarVoto.php",
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
                        text: responseData.message
                    });
                }
            }
        });
    });

    // Evento al hacer clic en el botón "Eliminar voto"
    $(document).on('click', '.eliminar_voto_btn', function() {
        var idEmpresa = $(this).data('id');

        // Confirmar antes de eliminar el voto
        Swal.fire({
            title: '¿Está seguro?',
            text: 'Está a punto de eliminar el voto de esta empresa. Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', 
            cancelButtonColor: '#3085d6', 
            confirmButtonText: 'Sí, eliminar voto',
            cancelButtonText: 'Cancelar',
            customClass: {
                title: 'swal-title' 
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar la solicitud para eliminar el voto
                $.ajax({
                    type: "POST",
                    url: "../controller/eliminarVoto.php", // Debes crear este archivo para procesar la eliminación del voto
                    data: { id_empresa: idEmpresa },
                    success: function(response) {
                        var responseData = JSON.parse(response);
                        if (responseData.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Voto eliminado!',
                                text: responseData.message,
                                didClose: () => {
                                    location.reload(); // Recargar la página después de cerrar el Sweet Alert
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: responseData.message
                            });
                        }
                    }
                });
            }
        });
    });
});
