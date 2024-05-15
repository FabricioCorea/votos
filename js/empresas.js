$(document).ready(function() {
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




// Mostrar icono de carga
$('#cargando').removeClass('oculto');

// Ocultar la tabla mientras se cargan los datos
$('#tablaVotos').addClass('oculto');

// Llamar a la función para cargar votos
CargarVotos(idioma_espanol);
});

// Función para cargar votos (empresas)
function CargarVotos(idioma_espanol) {
    // Mostrar indicador de carga
    $('#loadingIndicator').show();

    $.ajax({
        url: '../controller/empresas.php', // Ruta al controlador
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var votos = response;

            // Limpiar la tabla antes de agregar nuevos datos
            $('#dataVotos').empty();

            // Recorrer los datos y agregar las filas a la tabla
            votos.forEach(function(voto) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + voto.id + '</td>' +
                    '<td>' + voto.empresa + '</td>' +
                    '<td>' + voto.representante + '</td>' +
                    // Botones de editar y eliminar
                    '<td>' +
                    '<button class="btn btn-icon btn-edit" data-toggle="tooltip" title="Editar" onclick="mostrarModalEditar(' + voto.id + ', \'' + voto.empresa + '\', \'' + voto.representante + '\')">' +
                    '<i class="material-icons">edit</i>' +
                    '</button>' +
                    '<button class="btn btn-icon btn-delete" data-toggle="tooltip" title="Eliminar" onclick="eliminarEmpresa(' + voto.id + ')">' +
                    '<i class="material-icons">delete</i>' +
                    '</button>' +
                    '</td>';

                $('#dataVotos').append(row);
            });

            // Ocultar indicador de carga después de cargar los datos
            $('#loadingIndicator').hide();

            // Inicializar DataTables con idioma español
            $('#tablaVotos').DataTable({
                language: idioma_espanol
            });

            // Mostrar la tabla después de cargar los datos
            $('#tablaVotos').show(); // Asegurarse de que la tabla esté visible
        },
        error: function(xhr, status, error) {
            // Ocultar indicador de carga en caso de error
            $('#loadingIndicator').hide();
            // Manejar errores de la solicitud AJAX
            console.error(error);
            Swal.fire('Error', 'Hubo un error al cargar los datos de los votos', 'error');
        }
    });
}


// Función para agregar una nueva empresa
function AgregarEmpresa() {
    // Recoger los datos del formulario
    var id = document.getElementById('idModal').value.trim();
    var empresa = document.getElementById('empresaModal').value.trim();
    var representante = document.getElementById('representanteModal').value.trim();
    // Verificar que se hayan ingresado los datos
    if (id === '' || empresa === '' || representante === '') {
        Swal.fire("Advertencia", "Debe llenar todos los campos", "warning");
        return;
    }
    
    // Validar que el ID contenga solo números
    if (!/^\d+$/.test(id)) {
        Swal.fire("Advertencia", "El ID debe contener solo números", "warning");
        return;
    }

    // Verificar que el representante no contenga números ni caracteres especiales
if (!/^[a-zA-ZñÑ@!*$&#`´/%.,_\s\-]+$/.test(representante)) {
        Swal.fire("Advertencia", "El nombre del representante no debe contener números", "warning");
        return;
    }
    // Crear un objeto para los datos que se enviarán
    var data = {
        id: id,
        empresa: empresa,
        representante: representante
    };
    // Realizar una solicitud POST al servidor
    fetch('../controller/empresas.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(response => {
            if (response.mensaje === 'Empresa agregada correctamente') {
                Swal.fire({
                    icon: 'success',
                    title: 'Listo',
                    text: response.mensaje
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formAgregarEmpresa').reset(); // Resetear el formulario
                        $('#addEmpresaModal').modal('hide'); // Cerrar el modal
                        location.reload(); // Recargar la página
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + response.mensaje
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error en la solicitud'
            });
            console.error('Error en la solicitud:', error);
        });
}

// Función para validar el campo de ID
function validarId(input) {
    // Obtener el valor del campo y eliminar espacios en blanco al inicio y al final
    var id = input.value.trim();
    var regex = /^\d+$/;
    if (id === '') {
        input.classList.remove("is-invalid");
    } else {
        // Verificar si el valor del campo coincide con la expresión regular
        if (!regex.test(id)) {
            // Si no coincide, agregar clase de Bootstrap para mostrar mensaje de error
            input.classList.add("is-invalid");
        } else {
            // Si coincide, eliminar clase de Bootstrap para eliminar mensaje de error
            input.classList.remove("is-invalid");
        }
    }
}

// Agregar evento de input para validar el campo de ID
document.getElementById('idModal').addEventListener('input', function() {
    validarId(this);
});


// Función para validar el campo de representante
// Función para validar el campo de representante
function validarRepresentante(input) {
    // Obtener el valor del campo y eliminar espacios en blanco al inicio y al final
    var representante = input.value.trim();
    
    // Expresión regular que permite letras, espacios y otros caracteres específicos
    var regex = /^[a-zA-ZñÑ@!*$&#`´/%.,_\-\s]+$/;

    // Verificar si el campo está vacío
    if (representante === '') {
        // Si está vacío, eliminar la clase de Bootstrap para eliminar mensaje de error
        input.classList.remove("is-invalid");
    } else {
        // Verificar si el valor del campo coincide con la expresión regular
        if (!regex.test(representante)) {
            // Si no coincide, agregar clase de Bootstrap para mostrar mensaje de error
            input.classList.add("is-invalid");
        } else {
            // Si coincide, eliminar clase de Bootstrap para eliminar mensaje de error
            input.classList.remove("is-invalid");
        }
    }
}

// Agregar eventos de input para convertir a mayúsculas en tiempo real y validar el campo de representante
document.getElementById('empresaModal').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});

document.getElementById('representanteModal').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
    validarRepresentante(this);
});

    // Función para cargar datos de empresa en el modal de edición
    function cargarDatosEmpresa(idEmpresa, nombreEmpresa, representante) {
        document.getElementById('editEmpresaId').value = idEmpresa;
        document.getElementById('editEmpresaNombre').value = nombreEmpresa;
        document.getElementById('editEmpresaRepresentante').value = representante;
    }


    // Función para editar una empresa

    function editarEmpresa() {
        var empresa = document.getElementById('editEmpresaNombre').value.trim();
        var representanteInput = document.getElementById('editEmpresaRepresentante');
        var representante = representanteInput.value.trim().toUpperCase();
    
        // Verificar que se hayan ingresado ambos campos
        if (empresa === '' || representante === '') {
            Swal.fire("Advertencia", "Debe llenar todos los campos", "warning");
            return;
        }
    
        // Expresión regular que verifica si el representante contiene solo letras y espacios
        var regex = /^[a-zA-ZñÑ@!*$&#`´/%.,_\-\s]+$/;
    
        // Verificar si el valor del campo coincide con la expresión regular
        if (!regex.test(representante)) {
            // Si no coincide, mostrar alerta de SweetAlert
            Swal.fire("Advertencia", "El nombre del representante no debe contener números", "warning");
            return;
        }
    
        var id = document.getElementById('editEmpresaId').value;
    
        var data = {
            id: id,
            empresa: empresa,
            representante: representante
        };
    
        fetch('../controller/empresas2.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(response => {
            if (response.mensaje === 'Empresa actualizada correctamente') {
                Swal.fire({
                    icon: 'success',
                    title: 'Listo',
                    text: response.mensaje
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#editEmpresaModal').modal('hide'); // Cerrar modal de edición
                        location.reload(); // Recargar la página
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + response.mensaje
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error en la solicitud'
            });
            console.error('Error en la solicitud:', error);
        });
    }
    

    // Función para mostrar modal de edición al hacer clic en el botón Editar
    function mostrarModalEditar(idEmpresa, nombreEmpresa, representante) {
        cargarDatosEmpresa(idEmpresa, nombreEmpresa, representante);
        $('#editEmpresaModal').modal('show');
    }



    // Función para validar el campo de representante en el modal de edición
    function validarRepresentanteEdit(input) {
        // Obtener el valor del campo y eliminar espacios en blanco al inicio y al final
        var representante = input.value.trim();
        
        // Expresión regular que permite letras, espacios y otros caracteres específicos
        var regex = /^[a-zA-ZñÑ@!*$&#`´/%.,_\-\s]+$/;
        
        // Verificar si el campo está vacío
        if (representante === '') {
            // Si está vacío, eliminar la clase de Bootstrap para eliminar mensaje de error
            input.classList.remove("is-invalid");
        } else {
            // Verificar si el valor del campo coincide con la expresión regular
            if (!regex.test(representante)) {
                // Si no coincide, agregar clase de Bootstrap para mostrar mensaje de error
                input.classList.add("is-invalid");
            } else {
                // Si coincide, eliminar clase de Bootstrap para eliminar mensaje de error
                input.classList.remove("is-invalid");
            }
        }
    }
    
    
// Agregar eventos de input para validar el campo de representante en el modal de edición
document.getElementById('editEmpresaNombre').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});

document.getElementById('editEmpresaRepresentante').addEventListener('input', function() {
    validarRepresentanteEdit(this);
});

 // Función para eliminar una empresa
 function eliminarEmpresa(idEmpresa) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción eliminará la empresa. ¿Desea continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // solicitud de eliminación
            fetch('../controller/empresas2.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: idEmpresa })
                })
                .then(response => response.json())
                .then(response => {
                    if (response.mensaje === 'Empresa eliminada correctamente') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Listo',
                            text: response.mensaje
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Recargar la página después de eliminar la empresa
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: ' + response.mensaje
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error en la solicitud'
                    });
                    console.error('Error en la solicitud:', error);
                });
        }
    });
}
 // Agregar eventos de input para convertir a mayúsculas en tiempo real
 document.getElementById('editEmpresaNombre').addEventListener('input', function() {
    convertirAMayusculas(this);
});

document.getElementById('editEmpresaRepresentante').addEventListener('input', function() {
    convertirAMayusculas(this);
    validarRepresentante(this);
});

