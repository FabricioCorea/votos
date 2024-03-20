<?php
session_start(); // Iniciar la sesión

$varsesion = $_SESSION['usuario'];
    if($varsesion == null || $varsesion ==''){
        header("location: ../Formularios/login.php");
        die();
    }
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
</head>

<body>
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
                        <th>Contraseña</th>
                        <th>Última conexión</th>
                        <th>Creado por</th>
                        <th>Fecha creación</th>
                        <th>Modificado por</th>
                        <th>Fecha modificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="dataUsuarios">
                    <!-- Aquí se insertarán las filas de la tabla mediante JavaScript -->
                </tbody>
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
                            <label for="rolSelect" class="form-label">Rol</label>
                            <select class="form-select" id="rolSelect" name="rolSelect">
                                <!-- Roles mediante Javascript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control valid ValidUsuario" onpaste="return false;" placeholder="Ingrese el usuario" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control valid ValidNombre" onpaste="return false;" placeholder="Ingrese el nombre del usuario" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="selecEstado" class="form-label">Estado</label>
                            <select class="form-select" id="selecEstado" name="selecEstado">
                                <!-- Estado del usuario mediante Javascript -->
                            </select>
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
                    <button type="button" class="btn btn-primary" onclick="AgregarUsuario()">Guardar</button>
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
</body>

</html>
