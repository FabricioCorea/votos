var urlUsuarios = '../controller/usuarios.php?opc=GetUsuarios';
var UrlInsertarUsuario = '../controller/usuarios.php?opc=InsertUsuario';
var UrlEliminarUsuario = '../controller/usuarios.php?opc=DeleteUsuario';
var UrlGetRoles = '../controller/usuarios.php?opc=GetRoles';

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
        if (!testNombre(inputValue)) {
          this.classList.add("is-invalid");
          this.setAttribute("title", "El nombre debe ser alfabético, con máximo un espacio entre letras y sin números ni caracteres especiales");
        } else {
          this.classList.remove("is-invalid");
          this.removeAttribute("title");
        }
      });
  
      ValidNombre.addEventListener("keydown", function(event) {
        // Capturamos la tecla presionada
        var keyPressed = event.key;
        // Si la tecla presionada es un espacio y el cursor está en la primera posición del campo
        if (keyPressed === ' ' && this.selectionStart === 0) {
          // Cancelamos el evento de teclado para evitar que se ingrese el espacio
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
              // Crea un elemento <div> para contener la contraseña y aplicar el desplazamiento horizontal
              var contraseñaCell = '<div class="scrollable-cell contraseña">' + usuario.contraseña + '</div>';
              var rolCell = '<div class="scrollable-cell rol">' + usuario.rol + '</div>';

              // Agrega la fila a DataTables, reemplazando la celda de contraseña con la nueva celda que tiene desplazamiento horizontal
              var row = tablaUsuarios.row.add([
                  usuario.id_usuario,
                  rolCell,
                  usuario.usuario,
                  usuario.nombre,
                  usuario.estado,
                  contraseñaCell, // Utiliza la celda con desplazamiento horizontal en lugar de usuario.contraseña directamente
                  usuario.fecha_ultima_conexion,
                  usuario.creado_por,
                  usuario.fecha_creacion,
                  usuario.modificado_por,
                  usuario.fecha_modificacion,
                  // Botones de acciones (editar y eliminar)
                  '<button class="btn btn-icon btn-edit" data-toggle="tooltip" title="Editar"><i class="material-icons">edit</i></button>' +
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
    // Validación de campos vacíos
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
                  title: 'Éxito',
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
                          title: 'Éxito',
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
            for(i=0; i<MisItems.length; i++){ //Muestra Id y nombre
                opciones += '<option value="' + MisItems[i].id_rol + '">' +  MisItems[i].rol + '</option>';
            }
            $("#rolSelect").html(opciones);
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
}

// Evento click para botón agregar usuario
$('#btnAgregarUsuario').click(function() {
    // Aquí puedes agregar tu lógica para mostrar un formulario de registro
    // o redireccionar a una página de registro de usuario.
    console.log('Agregar usuario');
});

// Evento click para botones editar y eliminar
$('#tablaUsuarios tbody').on('click', '.btn-editar', function() {
    // Aquí puedes agregar tu lógica para editar un usuario
    var data = tablaUsuarios.row($(this).parents('tr')).data();
    console.log('Editar usuario', data[0]); // Ejemplo: obtener el ID del usuario
}).on('click', '.btn-eliminar', function() {
    // Aquí puedes agregar tu lógica para eliminar un usuario
    var data = tablaUsuarios.row($(this).parents('tr')).data();
    console.log('Eliminar usuario', data[0]); // Ejemplo: obtener el ID del usuario
});

// Agregar margen inferior al buscador del DataTable
$('input[type="search"]').css('margin-bottom', '20px');
