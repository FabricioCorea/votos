<?php
session_start(); // Iniciar la sesión

$varsesion = $_SESSION['usuario'];
    if($varsesion == null || $varsesion ==''){
        header("location: ../Formularios/login.php");
        die();
    }
    $rolUsuarioSesion = $_SESSION['usuario']['id_rol'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style-usuarios.css">
    <link rel="stylesheet" href="../CSS/header.css">
     <!-- Scrollbar Custom CSS -->
     <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'><link rel="stylesheet" href="./style.css">
     <!-- Tweaks for older IEs -->
     <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body>
    <nav>
        <div class="wrapper">
            <div class="logoIMG">
                <a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1' || $_SESSION['usuario']['id_rol'] == '0') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">
                    <img class="small-image" src="../images/logo-transparente.webp" alt="#" />
                </a>
            </div>

            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1' || $_SESSION['usuario']['id_rol'] == '0') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">INICIO</a></li>
                <li>
                    <a href="#" class="desktop-item">
                        <span class="icon-right"> 
                        <i class="fas fa-user"></i> 
                        </span>
                        <?php echo $_SESSION['usuario']['usuario']; ?>
                    </a>
                </li>
                <li><a href="logout.php"> <i title="Cerrar Sesión" class="fas fa-sign-out-alt"></i></a><span class="sr-only">Cerrar Sesión&gt;</span></a></li>
            </ul>
        </div>
    </nav>

    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Gestión de <b>Usuarios</b></h2>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <div class="agregar-container" style="float: right;">
                            <div class="AgregarUsuario">
                                <div class="input-group">
                                    <button class="btn btn-success" style="background-color: #26a042; color: white; margin-left: 15px;" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                                        <i class="material-icons" style="color: white;">&#xE147;</i> <span>Agregar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <table class="table table-striped" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Rol</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Última conexión</th>
                        <th>Creado por</th>
                        <th>Fecha creación</th>
                        <th>Modificado por</th>
                        <th>Fecha modificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

   <!-- Modal para agregar usuario -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarUsuario">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control valid ValidUsuario" onpaste="return false;" placeholder="Ingrese el usuario" autocomplete="off">
                        </div>
                        <div class="mb-3 d-flex">
                            <div style="flex: 1;">
                                <label for="rolSelect" class="form-label">Rol</label>
                                <select class="form-select" id="rolSelect" name="rolSelect">
                                    <!-- Roles mediante Javascript -->
                                </select>
                            </div>
                            <div style="flex: 1;">
                                <label for="selecEstado" class="form-label">Estado</label>
                                <select class="form-select" id="selecEstado" name="selecEstado">
                                    <!-- Estado del usuario mediante Javascript -->
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control valid ValidNombre" onpaste="return false;" placeholder="Ingrese el nombre del usuario" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" name="contraseña" id="contraseña" class="form-control valid ValidContra" onpaste="return false;" placeholder="Ingrese la contraseña">
                        </div>
                        <div class="mb-3">
                            <label for="confirmContraseña" class="form-label">Confirmar contraseña</label>
                            <input type="password" id="confirmContraseña" name="confirmContraseña" class="form-control valid ValidContra" onpaste="return false;" placeholder="Ingrese la contraseña">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="AgregarUsuario()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarUsuario">
                        <input type="hidden" id="editIdUsuario" name="editIdUsuario">
                        <div class="mb-3">
                            <label for="editUsuario" class="form-label">Usuario</label>
                            <input type="text" name="editUsuario" id="editUsuario" class="form-control valid ValidUsuario" onpaste="return false;" placeholder="Ingrese el usuario" autocomplete="off">
                        </div>
                        <div class="mb-3 d-flex">
                            <div style="flex: 1;">
                                <label for="editRolSelect" class="form-label">Rol</label>
                                <select class="form-select" id="editRolSelect" name="editRolSelect">
                                    <!-- Roles mediante Javascript -->
                                </select>
                            </div>
                            <div style="flex: 1;">
                                <label for="editSelecEstado" class="form-label">Estado</label>
                                <select class="form-select" id="editSelecEstado" name="editSelecEstado">
                                    <!-- Estado del usuario mediante Javascript -->
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre</label>
                            <input type="text" name="editNombre" id="editNombre" class="form-control valid ValidNombre" onpaste="return false;" placeholder="Ingrese el nombre del usuario" autocomplete="off">
                        </div>
                        <div class="mb-3" id="nuevaContrasena" style="display: none;">
                            <label for="EditContraseña" class="form-label">Nueva contraseña</label>
                            <input type="password" name="EditContraseña" id="EditContraseña" class="form-control valid ValidContra" onpaste="return false;" placeholder="Ingrese la nueva contraseña">
                        </div>
                        <div class="mb-3" id="confirmarContrasena" style="display: none;">
                            <label for="confirmEditContraseña" class="form-label">Confirmar contraseña</label>
                            <input type="password" id="confirmEditContraseña" name="confirmEditContraseña" class="form-control valid ValidContra" onpaste="return false;" placeholder="Ingrese la contraseña">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnNuevaContrasena">Nueva Contraseña</button>
                    <button type="button" class="btn btn-primary" onclick="ActualizarUsuario()">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="../JS/usuarios.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

    <!-- Inactividad JavaScript -->
    <script src="../JS/inactividad.js"></script>
    <script type="text/javascript">
    // Asignar el rol del usuario en sesión a una variable JavaScript
    var rolUsuarioSesion = <?php echo $rolUsuarioSesion; ?>;
</script>
</body>

</html>
