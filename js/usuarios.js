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

function testContraseña(txtString) {
  var stringText = new RegExp(
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)([A-Za-z\d]|[^ ]){8,15}$/
  );
  return stringText.test(txtString);
}

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
                this.removeAttribute("title");
                return; // Salir de la función si el campo está vacío
            }

            // Realizar las validaciones solo si el campo no está vacío
            if (!testContraseña(inputValue)) {
                this.classList.add("is-invalid");
                this.setAttribute("title", "La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número");
            } else {
                this.classList.remove("is-invalid");
                this.removeAttribute("title");
            }
        });
    });
}

  function testUsuario(txtString) {
    // Expresión regular que verifica si el usuario contiene solo letras y números y no excede los 11 caracteres
    var regex = /^[a-zA-Z0-9]{1,11}$/;
    return regex.test(txtString);
  }
  
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
          this.removeAttribute("title");
          return; // Salir de la función si el campo está vacío
        }
  
        if (!testUsuario(inputValue)) {
          this.classList.add("is-invalid");
          this.setAttribute("title", "El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres");
        } else {
          this.classList.remove("is-invalid");
          this.removeAttribute("title");
        }
      });
    });
  }
  

  function testNombre(txtString) {
    // Expresión regular que verifica si el nombre es alfabético y tiene como máximo un espacio entre letras
    var regex = /^[a-zA-Z]+(?:\s[a-zA-Z]+)*\s?$/;
    return regex.test(txtString);
  }
  
  function fntValidNombre() {
    let ValidNombre = document.querySelectorAll(".ValidNombre");
    ValidNombre.forEach(function (ValidNombre) {
      ValidNombre.addEventListener("input", function () {
        let inputValue = this.value.toUpperCase(); // Convertir el texto a mayúsculas
        this.value = inputValue; // Establecer el valor convertido en mayúsculas
  
        // Verificar si el campo está vacío después de borrar el texto ingresado
        if (inputValue === '') {
          this.classList.remove("is-invalid");
          this.removeAttribute("title");
          return; // Salir de la función si el campo está vacío
        }
  
        if (!testNombre(inputValue)) {
          this.classList.add("is-invalid");
          this.setAttribute("title", "El nombre debe ser alfabético, con máximo un espacio entre letras y sin números ni caracteres especiales");
        } else {
          this.classList.remove("is-invalid");
          this.removeAttribute("title");
        }
      });
  
      ValidNombre.addEventListener("keydown", function(event) {
        // Captura la tecla presionada
        var keyPressed = event.key;
        // Si la tecla presionada es un espacio y el cursor está en la primera posición del campo
        if (keyPressed === ' ' && this.selectionStart === 0) {
          // Cancela el evento de teclado para evitar que se ingrese el espacio
          event.preventDefault();
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
                  // Botones de acciones (editar y eliminar)
                  '<button class="btn btn-icon btn-edit" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" onclick="CargarUsuario(\'' + usuario.id_usuario + '\')" title="Editar"><i class="material-icons">edit</i></button>' +
                  '<button class="btn btn-icon btn-delete" data-toggle="tooltip" title="Eliminar" onclick="EliminarUsuario(' + usuario.id_usuario + ')"><i class="material-icons">delete</i></button>'
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
    // Validación general de campos vacíos
    if (
        usuario == "" ||
        nombre == "" ||
        contraseña == ""
    ) {
        Swal.fire("Advertencia", "Debe llenar todos los campos", "warning");
        return false;
    }

    if (contraseñaValid.classList.contains("is-invalid")) {
        Swal.fire(
            "Advertencia",
            "La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número",
            "warning"
        );
        return false;
    }

    if (usuarioValid.classList.contains("is-invalid")) {
        Swal.fire(
            "Advertencia",
            "El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres",
            "warning"
        );
        return false;
    }

    if (nombreValid.classList.contains("is-invalid")) {
        Swal.fire(
            "Advertencia",
            "El nombre debe contener como máximo un espacio, sin números ni caracteres especiales",
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

//Función que trae los datos del usuario que se eligió editar
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
          $('#editSelecEstado').val(usuario.estado);

          // Seleccionar la opción correcta en el select de roles
          $('#editRolSelect option').filter(function() {
              return $(this).val() == usuario.id_rol; // Comparar el valor del option con el id_rol del usuario
          }).prop('selected', true);
      },
  });
}

//función para actualizar usuario
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
  
  // Validación general de campos vacíos
  if (
      usuario == "" ||
      nombre == ""
  ) {
      Swal.fire("Advertencia", "Debe llenar todos los campos", "warning");
      return false;
  }

  if (contraseñaValid.classList.contains("is-invalid")) {
      Swal.fire(
          "Advertencia",
          "La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número",
          "warning"
      );
      return false;
  }

  if (usuarioValid.classList.contains("is-invalid")) {
      Swal.fire(
          "Advertencia",
          "El usuario no puede contener caracteres especiales y debe tener máximo 11 caracteres",
          "warning"
      );
      return false;
  }
  
  if (nombreValid.classList.contains("is-invalid")) {
      Swal.fire(
          "Advertencia",
          "El nombre debe ser alfabético, con máximo un espacio y sin números ni caracteres especiales",
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
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
