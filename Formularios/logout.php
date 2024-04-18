<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
session_unset();
// Destruir la sesión
session_destroy();

// Redireccionar a la página de inicio de sesión o a donde desees
header("location: login.php");
exit();
?>
