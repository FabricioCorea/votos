<?php
session_start(); // Iniciar la sesión

// Incluir el archivo de control de permisos
include_once './controller/verificarPermisos.php';

// Verificar si el usuario está en sesión
if(isset($_SESSION['usuario'])) {
    // El usuario está en sesión
    $usuario = $_SESSION['usuario'];
    
    // Acceder a los datos del usuario
    echo "Bienvenido, " . $usuario['nombre'];

    $id_objeto = 1; // Definir el ID del objeto que se desea validar (id del objeto definido en la base de datos)
	$mostrarBotonAgregar = verificarPermisoInsercion($conn, $usuario, $id_objeto);
    $mostrarBotonActualizar = verificarPermisoActualizacion($conn, $usuario, $id_objeto);
    $mostrarBotonEliminar = verificarPermisoEliminacion($conn, $usuario, $id_objeto);
    $mostrarBotonConsultar = verificarPermisoConsultar($conn, $usuario, $id_objeto);

} else {
    // El usuario no está en sesión, redirigirlo al inicio de sesión
    header("Location: http://localhost/votos/Formularios/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <link rel="stylesheet" type="text/css" href="./CSS/forma.css">
</head>
<body>
    <form action="registro.php"  method="POST">
        <div id="container">
              <h1> Cámara de Comercio e Industria de Tegucigalpa </h1>
              <div class="underline">
              </div>
              <div class="icon_wrapper">
               <center><img    src="https://static.wixstatic.com/media/454fda_680644deb4cd4fbeb1e8e6b5bf3b79a5~mv2.png/v1/fill/w_205,h_89,al_c,q_80,usm_0.66_1.00_0.01/454fda_680644deb4cd4fbeb1e8e6b5bf3b79a5~mv2.webp">
                 </center>
              </div>
              <form action="#" method="post" id="contact_form">
                    <div class="name">
                      <label for="name"></label>
                      <input type="text" placeholder="Código Cliente" name="id" id="id_input" required>
                    </div>

                    <div class="subject">
                        <select placeholder="Subject line" name="subject" id="subject_input" required>
                            <option value="" disabled hidden selected>Presente:</option>
                            <option value="REPRESENTANTE">REPRESENTANTE</option>
                            <option value="REPRESENTADO">REPRESENTADO</option>
                        </select>
                    </div>
                    
                    <?php if ($mostrarBotonAgregar): ?>
                    <form>
                        
                            <center>
                                <div class="submit">
                                    <input type="submit" value="AGREGAR" id="form_button" />
                                </div>
                            </center>
                        </form>
                    <?php endif; ?>
                    <?php if ($mostrarBotonActualizar): ?>
                    <form>
                        
                            <center>
                                <div class="submit">
                                    <input type="submit" value="ACTUALIZAR" id="form_button" />
                                </div>
                            </center>
                        </form>
                    <?php endif; ?>
                    <?php if ($mostrarBotonEliminar): ?>
                    <form>
                        
                            <center>
                                <div class="submit">
                                    <input type="submit" value="ELIMINAR" id="form_button" />
                                </div>
                            </center>
                        </form>
                    <?php endif; ?>
                    <?php if ($mostrarBotonConsultar): ?>
                    <form>
                        
                            <center>
                                <div class="submit">
                                    <input type="submit" value="CONSULTAR" id="form_button" />
                                </div>
                            </center>
                        </form>
                    <?php endif; ?>
            </div><!-- // End #container -->
        </form>
    </body>
</html>

