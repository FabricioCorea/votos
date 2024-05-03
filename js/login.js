function alternarVisibilidadContrasenia() { // función para el Ojito que se muestra en el campo de contraseña.
    var passwordInput = document.getElementById("passwordInput");
    var eyeIcon = document.querySelector(".eye-icon i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }

    // Mostrar u ocultar el icono dependiendo de si hay texto en el campo de contraseña.
    if (passwordInput.value.trim() === "") {
        eyeIcon.style.visibility = "hidden";
    } else {
        eyeIcon.style.visibility = "visible";
    }
}

// Agregar un listener para detectar cambios en el campo de contraseña y actualizar la visibilidad del icono.
document.getElementById("passwordInput").addEventListener("input", function() {
    var passwordInput = document.getElementById("passwordInput");
    var eyeIcon = document.querySelector(".eye-icon i");

    if (passwordInput.value.trim() === "" && passwordInput.type === "password") {
        eyeIcon.style.visibility = "hidden";
    } else {
        eyeIcon.style.visibility = "visible";
    }
});

// Verificar la visibilidad del icono al cargar la página
window.onload = function() {
    var passwordInput = document.getElementById("passwordInput");
    var eyeIcon = document.querySelector(".eye-icon i");

    if (passwordInput.value.trim() === "" && passwordInput.type === "password") {
        eyeIcon.style.visibility = "hidden";
    } else {
        eyeIcon.style.visibility = "visible";
    }
};

function validarAcceso(event) {
    event.preventDefault(); // Evitar que se envíe el formulario 

    // Obtener valores de los campos
    var usuario = document.getElementById('usuario').value.trim();
    var password = document.getElementById('passwordInput').value.trim();

    // Obtener referencia al div del mensaje de error
    var mensajeError = document.getElementById('mensaje-error');

    // Validar que los campos no estén vacíos
    if (usuario === '' || password === '') {
        mensajeError.innerText = "Por favor, complete todos los campos.";
        mensajeError.classList.remove('mensaje-error-visible'); // Remover la clase antes de agregarla nuevamente
        void mensajeError.offsetWidth; // Forzar el reflow para reiniciar la animación
        mensajeError.classList.add('mensaje-error-visible'); // Agregar la clase para mostrar el mensaje de error
        return; // Detener el envío del formulario si hay campos vacíos
    }

    // Crear objeto FormData y enviar formulario mediante AJAX
    var formData = new FormData(document.querySelector('form'));
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Manejar la respuesta del servidor
                var jsonResponse = JSON.parse(xhr.responseText);
                if (jsonResponse.status === "success") {
                    var rol = jsonResponse.rol;
                    // Redirigir según el rol del usuario
                    if (rol === "1") {
                        window.location.href = "../formularios/indexAdmin.php";
                    } else if (rol === "2") {
                        window.location.href = "../formularios/indexUsuario.php";
                    } else {
                        console.error('Rol de usuario desconocido.');
                    }
                } else {
                    // Mostrar mensaje de error si hubo un error
                    mensajeError.innerText = jsonResponse.message; 
                    mensajeError.classList.remove('mensaje-error-visible');
                    void mensajeError.offsetWidth;
                    mensajeError.classList.add('mensaje-error-visible');
                    // Limpiar campos de usuario y contraseña en caso de error
                    document.getElementById('usuario').value = '';
                    document.getElementById('passwordInput').value = '';
                }
            } else {
                console.error('Error al procesar la solicitud.');
                // Mostrar mensaje de error genérico en caso de error de conexión
                mensajeError.innerText = "Error al procesar la solicitud.";
                mensajeError.classList.remove('mensaje-error-visible');
                void mensajeError.offsetWidth;
                mensajeError.classList.add('mensaje-error-visible');
            }
        }
    };           
    xhr.open('POST', '../controller/login.php', true); // Método POST, enviar a login.php
    xhr.send(formData);
}
//Función para convertir las letras ingresadas al campo "usuario" a mayúsculas
function convertirMayusculas(tx){
    //Retornar valor convertido a mayusculas
     return tx.toUpperCase();
}