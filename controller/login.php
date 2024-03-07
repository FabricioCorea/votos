<?php
session_start(); // Iniciar la sesión

include '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el usuario y la contraseña enviados desde el formulario
    $email = $_POST['usuario'];
    $password = $_POST['password'];

    // Escapar caracteres especiales para evitar inyección de SQL
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Consulta para verificar el usuario y la contraseña
    $query = "SELECT * FROM tbl_usuarios WHERE usuario = '$email' AND contraseña = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);
        if ($usuario['estado'] == 'activo') {
            // Iniciar sesión y almacenar el usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            
            echo "success"; // Enviar respuesta de éxito
            exit();
        } else {
            echo "Su usuario no está activo. Por favor, contacte al administrador."; // Enviar mensaje de error
        }
    } else {
        echo "Usuario o contraseña incorrectos. Por favor, inténtelo otra vez."; // Enviar mensaje de error
    }
}

mysqli_close($conn);
?>
