var urlUsuarios = '../controller/usuarios.php?opc=GetUsuarios';
var UrlInsertarUsuario = '../controller/usuarios.php?opc=InsertUsuario';
var UrlEliminarUsuario = '../controller/usuarios.php?opc=DeleteUsuario';
var UrlGetRoles = '../controller/usuarios.php?opc=GetRoles';
var UrlUsuarioAEditar = '../controller/usuarios.php?opc=GetUsuarioAEditar';
var UrlActualizarUsuario = '../controller/usuarios.php?opc=UpdateUsuario';

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
var tablaUsuarios = $('#tablaUsuarios').DataTable({
    language: idioma_espanol
});

$(document).ready(function() {
    CargarUsuarios();
    CargarRoles();
    CargarEstados();
    fntValidContra();
    fntValidUsuario();
    fntValidNombre();
});
// Función para restablecer los mensajes de validación al cerrar el modal
function resetValidationFeedback() {
    document.querySelector("#EditContraseña + .invalid-feedback").innerHTML = '';
    document.querySelector("#editUsuario + .invalid-feedback").innerHTML = '';
    document.querySelector("#editNombre + .invalid-feedback").innerHTML = '';
    document.querySelector("#confirmEditContraseña + .invalid-feedback").innerHTML = '';

    // Remover la clase 'is-invalid' de los elementos relevantes
    document.querySelector("#EditContraseña").classList.remove("is-invalid");
    document.querySelector("#editUsuario").classList.remove("is-invalid");
    document.querySelector("#editNombre").classList.remove("is-invalid");
    document.querySelector("#confirmEditContraseña").classList.remove("is-invalid");

    //Remover el valor de los campos de contraseña
    document.getElementById("EditContraseña").value = '';
    document.getElementById("confirmEditContraseña").value = '';
}

// Adjuntar evento al modal de edición para restablecer los mensajes de validación
$('#editEmployeeModal').on('hidden.bs.modal', function () {
    resetValidationFeedback();
});


// Expresión regular para validar la contraseña
function testContraseña(txtString) {
    var stringText = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)([A-Za-z\d]|[^ ]){8,15}$/;
    return stringText.test(txtString);
}

// Función para validar la contraseña
function fntValidContra() {
    let ValidContra = document.querySelectorAll(".ValidContra");
    ValidContra.forEach(function (ValidContra) {
        ValidContra.addEventListener("keydown", function (event) {
            // Bloquear el ingreso del espacio
            if (event.key === " ") {
                event.preventDefault();
            }
        });

        ValidContra.addEventListener("keyup", function () {
            let inputValue = this.value;
            // Verificar si el campo está vacío después de borrar el texto ingresado
            if (inputValue === '') {
                this.classList.remove("is-invalid");
                // Ocultar el mensaje de validación si el campo está vacío
                this.nextElementSibling.innerHTML = ''; // Limpiar el contenido del div
                return; // Salir de la función si el campo está vacío
            }

            // Realizar las validaciones solo si el campo no está vacío
            if (!testContraseña(inputValue)) {
                this.classList.add("is-invalid");
                // Mostrar el mensaje de validación en el div correspondiente
                this.nextElementSibling.innerHTML = 'La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número';
            } else {
                this.classList.remove("is-invalid");
                // Ocultar el mensaje de validación si la contraseña es válida
                this.nextElementSibling.innerHTML = ''; // Limpiar el contenido del div
            }
        });
    });
}

// Expresión regular para validar el usuario
function testUsuario(txtString) {
    var regex = /^[a-zA-Z0-9]{1,11}$/;
    return regex.test(txtString);
}

// Función para validar el usuario
function fntValidUsuario() {
    let ValidUsuario = document.querySelectorAll(".ValidUsuario");
    ValidUsuario.forEach(function (ValidUsuario) {
        ValidUsuario.addEventListener("keydown", function (event) {
            // Bloquear el ingreso del espacio
            if (event.key === " ") {
                event.preventDefault();
            }
        });

        ValidUsuario.addEventListener("input", function () {
            let inputValue = this.value.toUpperCase(); // Convertir el texto a mayúsculas
            this.value = inputValue; // Establecer el valor convertido en mayúsculas

            // Verificar si el campo está vacío después de borrar el texto ingresado
            if (inputValue === '') {
                this.classList.remove("is-invalid");
                // Ocultar el mensaje de validación si el campo está vacío
                this.nextElementSibling.innerHTML = ''; // Limpiar el contenido del div
                return; // Salir de la función si el campo está vacío
            }

            if (!testUsuario(inputValue)) {
                this.classList.add("is-invalid");
                // Mostrar el mensaje de validación en el div correspondiente
                this.nextElementSibling.innerHTML = 'El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres';
            } else {
                this.classList.remove("is-invalid");
                // Ocultar el mensaje de validación si el usuario es válido
                this.nextElementSibling.innerHTML = ''; // Limpiar el contenido del div
            }
        });
    });
}

// Expresión regular para validar el nombre
function testNombre(txtString) {
    var regex = /^[a-zA-Z]+(?:\s[a-zA-Z]+)*\s?$/;
    return regex.test(txtString);
}

// Función para validar el nombre
function fntValidNombre() {
    let ValidNombre = document.querySelectorAll(".ValidNombre");
    ValidNombre.forEach(function (ValidNombre) {
        ValidNombre.addEventListener("input", function () {
            let inputValue = this.value.toUpperCase(); // Convertir el texto a mayúsculas
            this.value = inputValue; // Establecer el valor convertido en mayúsculas

            // Verificar si el campo está vacío después de borrar el texto ingresado
            if (inputValue === '') {
                this.classList.remove("is-invalid");
                // Ocultar el mensaje de validación si el campo está vacío
                this.nextElementSibling.innerHTML = ''; // Limpiar el contenido del div
                return; // Salir de la función si el campo está vacío
            }

            if (!testNombre(inputValue)) {
                this.classList.add("is-invalid");
                // Mostrar el mensaje de validación en el div correspondiente
                this.nextElementSibling.innerHTML = 'El nombre debe ser alfabético, con máximo un espacio entre letras y sin números ni caracteres especiales';
            } else {
                this.classList.remove("is-invalid");
                // Ocultar el mensaje de validación si el nombre es válido
                this.nextElementSibling.innerHTML = ''; // Limpiar el contenido del div
            }
        });
    });
}
// Función para cargar usuarios
function CargarUsuarios() {
    $.ajax({
        url: urlUsuarios,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var usuarios = response;

            // Limpiar la tabla antes de agregar nuevos datos
            tablaUsuarios.clear();

            // Recorrer los datos y agregar las filas a DataTables
            usuarios.forEach(function(usuario) {
                var botonesAcciones = ''; // Inicializar el string de botones como vacío

                // Verificar si el rol del usuario en sesión es SUPER USUARIO (0)
                if (rolUsuarioSesion == 0) {
                    // Permitir clicar en los botones solo para usuarios que no son SUPER USUARIO
                    if (usuario.id_rol != 0) {
                        botonesAcciones = '<button class="btn btn-icon btn-edit" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" onclick="CargarUsuario(\'' + usuario.id_usuario + '\')" title="Editar"><i class="material-icons">edit</i></button>' +
                            '<button class="btn btn-icon btn-delete" data-toggle="tooltip" title="Eliminar" onclick="EliminarUsuario(' + usuario.id_usuario + ')"><i class="material-icons">delete</i></button>';
                    } else {
                        // Solo mostrar el botón de editar para usuarios con rol SUPER USUARIO
                        botonesAcciones = '<button class="btn btn-icon btn-edit" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" onclick="CargarUsuario(\'' + usuario.id_usuario + '\')" title="Editar"><i class="material-icons">edit</i></button>';
                    }
                } else if (rolUsuarioSesion == 1) {
                    // Permitir clicar en los botones solo para usuarios que no son SUPER USUARIO ni ADMINISTRADOR
                    if (usuario.id_rol != 0 && usuario.id_rol != 1) {
                        botonesAcciones = '<button class="btn btn-icon btn-edit" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" onclick="CargarUsuario(\'' + usuario.id_usuario + '\')" title="Editar"><i class="material-icons">edit</i></button>' +
                            '<button class="btn btn-icon btn-delete" data-toggle="tooltip" title="Eliminar" onclick="EliminarUsuario(' + usuario.id_usuario + ')"><i class="material-icons">delete</i></button>';
                    } else {
                        botonesAcciones = '';
                    }
                }

                // Agrega la fila a DataTables, reemplazando la celda de contraseña con la nueva celda que tiene desplazamiento horizontal
                var row = tablaUsuarios.row.add([
                    usuario.id_usuario,
                    usuario.rol,
                    usuario.usuario,
                    usuario.nombre,
                    usuario.estado,
                    usuario.fecha_ultima_conexion,
                    usuario.creado_por,
                    usuario.fecha_creacion,
                    usuario.modificado_por,
                    usuario.fecha_modificacion,
                    botonesAcciones // Botones de acciones (editar y eliminar)
                ]).draw(false);

                // Agregar un atributo al botón de eliminar con el id_usuario
                $('td', row.node()).eq(11).find('.btn-delete').attr('data-id-usuario', usuario.id_usuario);
            });
        },
        error: function(xhr, status, error) {
            // Manejar errores de la solicitud AJAX
            console.error(error);
            Swal.fire('Error', 'Hubo un error al cargar los datos de los usuarios', 'error');
        }
    });
}
//Función para agregar usuario
function AgregarUsuario() {
    var rolSelect = document.getElementById("rolSelect").value;
    var usuario = document.getElementById("usuario").value;
    var nombre = document.getElementById("nombre").value;
    var selecEstado = document.getElementById("selecEstado").value;
    var contraseña = document.getElementById("contraseña").value;
    var confirmContraseña = document.getElementById("confirmContraseña").value;

    // Validaciones de campos específicos
    let contraseñaValid = document.querySelector("#contraseña");
    let usuarioValid = document.querySelector("#usuario");
    let nombreValid = document.querySelector("#nombre");
    let contraseñaFeedback = document.querySelector("#contraseña + .invalid-feedback");
    let usuarioFeedback = document.querySelector("#usuario + .invalid-feedback");
    let nombreFeedback = document.querySelector("#nombre + .invalid-feedback");

    // Validación general de campos vacíos
    if (
        usuario == "" ||
        nombre == "" ||
        contraseña == ""
    ) {
        Swal.fire("Advertencia", "Debe llenar todos los campos", "warning");
        return false;
    }

    if (usuarioValid.classList.contains("is-invalid")) {
        // Mostrar el mensaje de validación en el div correspondiente
        usuarioFeedback.innerHTML = 'El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres';
        Swal.fire(
            "Advertencia",
            "El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres",
            "warning"
        );
        return false;
    }
    
    if (nombreValid.classList.contains("is-invalid")) {
        // Mostrar el mensaje de validación en el div correspondiente
        nombreFeedback.innerHTML = 'El nombre debe contener como máximo un espacio, sin números ni caracteres especiales';
        Swal.fire(
            "Advertencia",
            "El nombre debe contener como máximo un espacio, sin números ni caracteres especiales",
            "warning"
        );
        return false;
    }

    if (contraseñaValid.classList.contains("is-invalid")) {
        // Mostrar el mensaje de validación en el div correspondiente
        contraseñaFeedback.innerHTML = 'La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número';
        Swal.fire(
            "Advertencia",
            "La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número",
            "warning"
        );
        return false;
    }

    // Validar contraseñas
    if (contraseña !== confirmContraseña) {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Las contraseñas no coinciden'
        });
        return;
    }

    // Restablecer los mensajes de validación si todos los campos son válidos
    contraseñaFeedback.innerHTML = '';
    usuarioFeedback.innerHTML = '';
    nombreFeedback.innerHTML = '';

  // Crear objeto con los datos del usuario
  var userData = {
      rolSelect: rolSelect,
      usuario: usuario,
      nombre: nombre,
      estadoSelect: selecEstado,
      contraseña: contraseña,
      confirmContraseña: confirmContraseña
  };

  // Enviar solicitud POST al controlador
  $.ajax({
      type: "POST",
      url: UrlInsertarUsuario,
      data: JSON.stringify(userData),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              Swal.fire({
                  icon: 'success',
                  title: 'Listo',
                  text: response.msg
              }).then((result) => {
                  if (result.isConfirmed) {
                      location.reload(); // Recargar la página después de agregar el usuario
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

// Función que trae los datos del usuario que se eligió editar
function CargarUsuario(idUsuario) {
    var datosUsuario = {
        idUsuario: idUsuario,
    };
    var datosUsuarioJson = JSON.stringify(datosUsuario);

    $.ajax({
        url: UrlUsuarioAEditar,
        type: "POST",
        data: datosUsuarioJson,
        datatype: "JSON",
        contentType: "application/json",
        success: function (response) {
            var usuario = response;

            console.log(usuario.nombre);
            // Llenar los campos del formulario de edición con los datos del usuario
            $('#editIdUsuario').val(usuario.id_usuario);
            $('#editUsuario').val(usuario.usuario);
            $('#editNombre').val(usuario.nombre);

            // Establecer el valor del campo de selección de rol
            $('#editRolSelect').val(usuario.id_rol);

            // Verificar si el usuario es SUPER USUARIO (rol 0)
            if (usuario.id_rol == 0) {
                // Si es SUPER USUARIO, deshabilitar el campo de selección de rol y estado
                $('#editRolSelect').prop('disabled', true);
                $('#editSelecEstado').prop('disabled', true);
            } else {
                // Si no es SUPER USUARIO, habilitar el campo de selección de rol
                $('#editRolSelect').prop('disabled', false);

                // Seleccionar la opción correcta en el select de estado
                $('#editSelecEstado').val(usuario.estado);

                // Habilitar el campo de selección de estado
                $('#editSelecEstado').prop('disabled', false);
            }
        },
    });
}

function ActualizarUsuario() {
    var idUsuario = document.getElementById("editIdUsuario").value;
    var rolSelect = document.getElementById("editRolSelect").value;
    var usuario = document.getElementById("editUsuario").value;
    var nombre = document.getElementById("editNombre").value;
    var selecEstado = document.getElementById("editSelecEstado").value;
    var contraseña = document.getElementById("EditContraseña").value;
    var confirmContraseña = document.getElementById("confirmEditContraseña").value;

    // Validaciones de campos específicos
    let contraseñaValid = document.querySelector("#EditContraseña");
    let usuarioValid = document.querySelector("#editUsuario");
    let nombreValid = document.querySelector("#editNombre");
    let contraseñaFeedback = document.querySelector("#EditContraseña + .invalid-feedback");
    let usuarioFeedback = document.querySelector("#editUsuario + .invalid-feedback");
    let nombreFeedback = document.querySelector("#editNombre + .invalid-feedback");

    // Validación general de campos vacíos
    if (usuario == "" || nombre == "") {
        Swal.fire("Advertencia", "Debe llenar todos los campos obligatorios", "warning");
        return false;
    }
    if (usuarioValid.classList.contains("is-invalid")) {
        // Mostrar el mensaje de validación en el div correspondiente
        usuarioFeedback.innerHTML = 'El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres';
        Swal.fire(
            "Advertencia",
            "El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres",
            "warning"
        );
        return false;
    }

    if (nombreValid.classList.contains("is-invalid")) {
        // Mostrar el mensaje de validación en el div correspondiente
        nombreFeedback.innerHTML = 'El nombre debe contener como máximo un espacio, sin números ni caracteres especiales';
        Swal.fire(
            "Advertencia",
            "El nombre debe contener como máximo un espacio, sin números ni caracteres especiales",
            "warning"
        );
        return false;
    }

    if (contraseña !== confirmContraseña) {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Las contraseñas no coinciden'
        });
        return false;
    }

    if (contraseñaValid.classList.contains("is-invalid")) {
        // Mostrar el mensaje de validación en el div correspondiente
        contraseñaFeedback.innerHTML = 'La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número';
        Swal.fire(
            "Advertencia",
            "La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número",
            "warning"
        );
        return false;
    }

    // Restablecer los mensajes de validación si todos los campos son válidos
    contraseñaFeedback.innerHTML = '';
    usuarioFeedback.innerHTML = '';
    nombreFeedback.innerHTML = '';

    // Crear objeto con los datos del usuario a actualizar
    var userData = {
        idUsuario: idUsuario,
        rolSelect: rolSelect,
        usuario: usuario,
        nombre: nombre,
        estadoSelect: selecEstado,
        contraseña: contraseña,
        confirmContraseña: confirmContraseña
    };

    // Enviar solicitud POST al controlador para actualizar el usuario
    $.ajax({
        type: "POST",
        url: UrlActualizarUsuario, // URL para actualizar el usuario
        data: JSON.stringify(userData),
        dataType: "json",
        success: function(response) {
            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Listo',
                    text: response.msg
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Recargar la página después de actualizar el usuario
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

// Función para mostrar/ocultar campos de nueva contraseña
document.getElementById("btnNuevaContrasena").addEventListener("click", function() {
    var nuevaContrasena = document.getElementById("nuevaContrasena");
    var confirmarContrasena = document.getElementById("confirmarContrasena");
    var btnNuevaContrasena = document.getElementById("btnNuevaContrasena");
    
    if (nuevaContrasena.style.display === "none") {
        nuevaContrasena.style.display = "block";
        confirmarContrasena.style.display = "block";
        btnNuevaContrasena.style.display = "none"; 
    } else {
        nuevaContrasena.style.display = "none";
        confirmarContrasena.style.display = "none";
        btnNuevaContrasena.style.display = "block"; 
    }
});

document.getElementById("editEmployeeModal").addEventListener("hidden.bs.modal", function () {
    var nuevaContrasena = document.getElementById("nuevaContrasena");
    var confirmarContrasena = document.getElementById("confirmarContrasena");
    var btnNuevaContrasena = document.getElementById("btnNuevaContrasena");
    
    nuevaContrasena.style.display = "none";
    confirmarContrasena.style.display = "none";
    btnNuevaContrasena.style.display = "block"; 
});



//Función para eliminar usuario
function EliminarUsuario(id_usuario) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción eliminará al usuario. ¿Desea continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Color rojo para el botón "Sí, eliminar"
        cancelButtonColor: '#3085d6', // Color azul para el botón "Cancelar"
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma la eliminación, se envía la solicitud de eliminación
            $.ajax({
                url: UrlEliminarUsuario,
                type: 'POST',
                data: { id_usuario: id_usuario },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Listo',
                            text: response.msg
                        }).then((result) => {
                            if (result.isConfirmed) {
                                CargarUsuarios(); // Recargar la lista de usuarios después de eliminar uno
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

function CargarRoles(){
    $.ajax({
        url : UrlGetRoles,
        type: 'GET',
        datatype: 'JSON',
        success: function(response){
            var MisItems = response;
            var opciones='';
            console.log(MisItems)
            for(i=0; i<MisItems.length; i++){ //Muestra el nombre del rol
                opciones += '<option value="' + MisItems[i].id_rol + '">' +  MisItems[i].rol + '</option>';
            }
            $("#rolSelect").html(opciones);
            $("#editRolSelect").html(opciones);
        }
    });
}

function CargarEstados() {
    // Define los estados
    var estados = ["ACTIVO", "INACTIVO"];

    // Genera las opciones de la lista desplegable
    var opciones = '';
    estados.forEach(function(estado) {
        opciones += '<option value="' + estado + '">' + estado + '</option>';
    });

    // Agrega las opciones al elemento select
    $("#selecEstado").html(opciones);
    $("#editSelecEstado").html(opciones);
}

// Agregar margen inferior al buscador del DataTable
$('input[type="search"]').css('margin-bottom', '20px');
