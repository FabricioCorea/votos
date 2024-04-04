var urlVotos = '../controller/empresas.php?opc=GetVotos';
var UrlInsertarVoto = '../controller/empresas.php?opc=InsertVoto';
var UrlEliminarVoto = '../controller/empresas.php?opc=DeleteVoto';

// Configuración de idioma personalizada
var idioma_espanol = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

// Inicializar DataTables con idioma español
var tablaVotos = $('#tablaVotos').DataTable({
    language: idioma_espanol
});

$(document).ready(function() {
    CargarVotos();
});

// Función para cargar votos
function CargarVotos() {
    $.ajax({
        url: urlVotos,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var votos = response;

            // Limpiar la tabla antes de agregar nuevos datos
            tablaVotos.clear(); 

            // Recorrer los datos y agregar las filas a DataTables
            votos.forEach(function(voto) {
                tablaVotos.row.add([
                    voto.id,
                    voto.empresa,
                    voto.representante,
                    // No se incluyen otros campos
                    // Botones de acciones (editar y eliminar)
                    '<button class="btn btn-icon btn-edit" data-toggle="tooltip" title="Editar"><i class="material-icons">edit</i></button>' +
                    '<button class="btn btn-icon btn-delete" data-toggle="tooltip" title="Eliminar" onclick="EliminarVoto(' + voto.id + ')"><i class="material-icons">delete</i></button>'
                ]).draw(false);
            });
        },
        error: function(xhr, status, error) {
            // Manejar errores de la solicitud AJAX
            console.error(error);
            Swal.fire('Error', 'Hubo un error al cargar los datos de los votos', 'error');
        }
    });
}

function AgregarVoto() {
    // Obtener los valores de los campos del formulario de agregar voto
    var empresa = document.getElementById("empresa").value;
    var representante = document.getElementById("representante").value;
    var presente = document.getElementById("presente").value;
    var representado = document.getElementById("representado").value;
    var voto = document.getElementById("voto").value;

    // Crear un objeto con los datos del voto
    var votoData = {
        empresa: empresa,
        representante: representante,
        presente: presente,
        representado: representado,
        voto: voto
    };

    // Realizar una solicitud AJAX para agregar el voto
    $.ajax({
        type: "POST",
        url: UrlInsertarVoto, // Reemplaza "ruta/al/controlador.php" con la ruta correcta a tu controlador
        data: JSON.stringify(votoData),
        contentType: "json",
        dataType: "json",
        success: function(response) {
            // Manejar la respuesta del servidor
            if (response.status) {
                // El voto se agregó correctamente
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.msg
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Recargar la página u otra lógica de tu aplicación después de agregar el voto
                        location.reload();
                    }
                });
            } else {
                // Se produjo un error al agregar el voto
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg
                });
            }
        },
        error: function(xhr, status, error) {
            // Manejar errores de la solicitud AJAX
            console.error(error);
            Swal.fire('Error', 'Hubo un error al procesar la solicitud', 'error');
        }
    });
}
function EliminarVoto(id_voto) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción eliminará la empresa . ¿Desea continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma la eliminación, se envía la solicitud de eliminación
            $.ajax({
                url: UrlEliminarVoto,
                type: 'POST',
                data: { id_voto: id_voto },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.msg
                        }).then((result) => {
                            if (result.isConfirmed) {
                                CargarVotos(); // Recargar la lista de votos después de eliminar uno
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.msg
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud'
                    });
                    console.error(xhr.responseText);
                }
            });
        }
    });
}
