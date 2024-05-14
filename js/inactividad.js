// Función para redirigir a la página de cierre de sesión después de 1 minuto de inactividad
var tiempoInactividad = 1800; // segundos
var tiempoInicio;

function resetTiempo() {
    clearTimeout(tiempoInicio);
    tiempoInicio = setTimeout(function() {
        window.location.href = 'logout.php'; // Redirigir a la página de cierre de sesión
    }, tiempoInactividad * 1000); // Convertir segundos a milisegundos
}

// Reiniciar el contador de inactividad en eventos de interacción del usuario
document.onmousemove = resetTiempo;
document.onkeypress = resetTiempo;

// Iniciar el contador de inactividad cuando se carga la página
window.onload = resetTiempo;