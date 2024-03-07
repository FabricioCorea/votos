<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-form sign-up">
        <div class="welcome-back">
            <div class="message">
                <img src="https://static.wixstatic.com/media/454fda_680644deb4cd4fbeb1e8e6b5bf3b79a5~mv2.png/v1/fill/w_205,h_89,al_c,q_80,usm_0.66_1.00_0.01/454fda_680644deb4cd4fbeb1e8e6b5bf3b79a5~mv2.webp" alt="CCIT Logo">
                <br>
                <h2 class="primera_linea">Bienvenido a Asamblea CCIT</h2> <br>
                <h2 class="segunda_linea">Registro de votos</h2>
            </div>
        </div>
    
        <form class="formulario-log-in" action="../controller/login.php" method="POST">
            <br>
            <img class="img-usuario-logo" src="../IMG/usuario.png">
            <h2 class="texto-log-in">Iniciar Sesión</h2>
            <div class="input-wrapper">
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" onkeyup="this.value=convertirMayusculas(this.value)" autocomplete="off">
            </div>
            <div class="input-wrapper">
                <input type="password" id="passwordInput" name="password" placeholder="Contraseña">
                <span class="eye-icon" onclick="alternarVisibilidadContrasenia()"><i class="fa fa-eye-slash"></i></span>
            </div>
            <input type="submit" value="Iniciar Sesión" name="boton-login" onclick="validarAcceso(event)">
            <br>
            <div id="mensaje-error" class="mensaje-error"></div>
        </form>
    </div>
    <script src="../JS/script-login.js"></script>
</body>

</html>
