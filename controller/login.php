<?php
session_start(); // Iniciar la sesión

include '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el usuario y la contraseña enviados desde el formulario
    $email = $_POST['usuario'];
    $password = $_POST['password'];

    // Escapar caracteres especiales para evitar inyección de SQL
    $email = mysqli_real_escape_string($conn, $email);

    // Consulta para verificar el usuario
    $query = "SELECT *, id_rol, contraseña FROM tbl_usuarios WHERE usuario = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);
        if ($usuario['estado'] == 'activo' || $usuario['estado'] == 'ACTIVO') {
            // Verificar contraseña
            if (password_verify($password, $usuario['contraseña'])) {
                // Iniciar sesión y almacenar el usuario en la sesión
                $_SESSION['usuario'] = $usuario;

                //Guardar la fecha del último ingreso del usuario
                $fecha_actual = date('Y-m-d H:i:s');
                $sql = $conn->query(" UPDATE tbl_usuarios SET fecha_ultima_conexion = '$fecha_actual' where usuario='$email'");

                // Preparar el array de respuesta incluyendo el rol del usuario
                $response = array(
                    'status' => 'success',
                    'rol' => $usuario['id_rol']
                );

                // Enviar respuesta JSON al JavaScript
                echo json_encode($response);
                exit();
            } else {
                // Contraseña incorrecta
                $response = array(
                    'status' => 'error',
                    'message' => 'Usuario o contraseña incorrectos. Por favor, inténtelo otra vez.'
                );
                echo json_encode($response);
                exit();
            }
        } else {
            // Usuario no activo
            $response = array(
                'status' => 'error',
                'message' => 'Su usuario no está activo. Por favor, contacte al administrador.'
            );
            echo json_encode($response);
            exit();
        }
    } else {
        // Usuario no encontrado
        $response = array(
            'status' => 'error',
            'message' => 'Usuario o contraseña incorrectos. Por favor, inténtelo otra vez.'
        );
        echo json_encode($response);
        exit();
    }
}

mysqli_close($conn);
?>
