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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Votos</title>
    <!-- CSS only -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style-empresas2.css">
    <link rel="stylesheet" href="../CSS/headerEmpresas.css">
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
                <a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">
                    <img class="small-image" src="../images/logo-transparente.webp" alt="#" />
                </a>
            </div>

            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">INICIO</a></li>
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
                            <h2>Gestión de <b>Empresas</b></h2>
                        </div>
                        <div class="col-sm-6" style="text-align: right;">
                            <div class="agregar-container" style="float: right;">
                                <div class="AgregarVoto">
                                    <div class="input-group">
                                        <button class="btn btn-success" style="background-color: #26a042; color: white; margin-left: 15px;" data-bs-toggle="modal" data-bs-target="#addEmpresaModal">
                                            <i class="material-icons" style="color: white;">&#xE147;</i> <span>Agregar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- Mostrar -->
        <label for="pageSize" style="display: inline-block; margin-right: 5px;">Mostrar</label>
        <select id="pageSize" onchange="changePageSize()" class="select-k select-c form-select-c" style="display: inline-block; margin-right: 5px;">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span style="display: inline-block;">registros</span>

        <!-- Búsqueda -->
        <div class="mb-3" style="float: right; text-align: right;">
            <label for="busquedaInput" class="form-label">Buscar:</label>
            <input type="text" id="busquedaInput" class="form-control" onkeyup="realizarBusqueda()" style="width: 200px; display: inline-block;">
        </div>

        <table id="tablaEmpresas" class="table table-striped">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">ID <span id="idArrow" class="arrow asc desc"></span></th>
                    <th>Empresa</th>
                    <th>Representante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaEmpresas"></tbody>
        </table>

        <!-- Paginación  -->
        <div class="pagination"></div>

        <!-- Mostrando  -->
        <span id="infoRegistros"></span>
        
        </div>  
    </div>

        <!-- Modal para agregar empresa -->
        <div class="modal fade" id="addEmpresaModal" tabindex="-1" aria-labelledby="addEmpresaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEmpresaModalLabel">Agregar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarEmpresa">
                        <div class="mb-3">
                            <label for="idModal" class="form-label">Id</label>
                            <input type="text" name="id" id="idModal" class="form-control" onpaste="return false;" placeholder="Ingrese el id de la empresa" autocomplete="off" required>
                            <div class="invalid-feedback">
                                El ID debe ser numérico
                            </div>
                        </div>

                            <div class="mb-3">
                                <label for="empresaModal" class="form-label">Empresa</label>
                                <input type="text" name="empresa" id="empresaModal" class="form-control" onpaste="return false;" placeholder="Ingrese el nombre de la empresa" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="representanteModal" class="form-label">Representante</label>
                                <input type="text" name="representante" id="representanteModal" class="form-control" onpaste="return false;" placeholder="Ingrese el nombre del representante" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    El nombre debe ser alfabético y no contener números
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarEmpresa" onclick="AgregarEmpresa()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar empresa -->
        <div class="modal fade" id="editEmpresaModal" tabindex="-1" aria-labelledby="editEmpresaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEmpresaModalLabel">Editar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarEmpresa">
                            <input type="hidden" id="editEmpresaId" name="id">
                            <div class="mb-3">
                                <label for="editEmpresaNombre" class="form-label">Nombre de la Empresa</label>
                                <input type="text" name="empresa" id="editEmpresaNombre" class="form-control" placeholder="Ingrese el nuevo nombre de la empresa" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmpresaRepresentante" class="form-label">Representante</label>
                                <input type="text" name="representante" id="editEmpresaRepresentante" class="form-control" placeholder="Ingrese el nuevo representante de la empresa" autocomplete="off" required>
                                <div class="invalid-feedback">
                                El nombre debe ser alfabético y no contener números
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="editarEmpresa()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="../JS/empresas2.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

</body>
</html>


