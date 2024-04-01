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
    <title>Votos</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style-empresas.css">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<style>    
body {
	color: #202e42;
     background-repeat: no-repeat;
	 background-size: cover;
     display: flex;
     justify-content: center;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
}
.table-responsive {
    margin: 10px 0;
}
.table-wrapper {
	background: #FFFFFF;
	padding: 20px 25px;
	border-radius: 3px;
	min-width: 1000px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {        
	padding-bottom: 15px;
	background: #34495E;
	color: #FFFFFF;
	padding: 16px 30px;
	min-width: 100%;
	margin: -2px -2px 10px;
	border-radius: 3px 3px 0 0;
}
.table-title h2 {
	margin: 5px 0 0;
	font-size: 24px;
}
.table-title .btn-group {
	float: right;
}

.table-title .btn i {
	float: left;
	font-size: 21px;
	margin-right: 5px;
}
.table-title .btn span {
	float: left;
	margin-top: 2px;
}
table.table tr th, table.table tr td {
	border-color: #e9e9e1;
	padding: 12px 15px;
	vertical-align: middle;
}
table.table tr th:first-child {
	width: 60px;
}
table.table tr th:last-child {
	width: 100px;
}
table.table-striped tbody tr:nth-of-type(odd) {
	background-color: #fcfcfc;
}
table.table-striped.table-hover tbody tr:hover {
	background: #d6ebf5;
}
table.table th i {
	font-size: 13px;
	margin: 0 5px;
	cursor: pointer;
}	
table.table td:last-child i {
	opacity: 0.9;
	font-size: 22px;
	margin: 0 5px;
}
table.table td a {
	font-weight: bold;
	color: #566787;
	display: inline-block;
	text-decoration: none;
	outline: none !important;
}
table.table td a:hover {
	color: #2196F3;
}
table.table td a.edit {
	color: #515e64;
}
table.table td a.delete {
	color: #F44336;
}
table.table td i {
	font-size: 19px;
}
table.table .avatar {
	border-radius: 50%;
	vertical-align: middle;
	margin-right: 10px;
}
.pagination {
	float: right;
	margin: 0 0 5px;
}
.pagination li a {
	border: none;
	font-size: 13px;
	min-width: 30px;
	min-height: 30px;
	color: #999;
	margin: 0 2px;
	line-height: 30px;
	border-radius: 2px !important;
	text-align: center;
	padding: 0 6px;
}
.pagination li a:hover {
	color: #666;
}	
.pagination li.active a, .pagination li.active a.page-link {
	background: #e99e00;
}
.pagination li.active a:hover {        
	background: #e99e00;
}
.pagination li.disabled i {
	color: #ccc;
}
.pagination li i {
	font-size: 16px;
	padding-top: 6px
}
  

/*Botones editar y eliminar */
.btn-icon {
    background: none;
    border: none;
    padding: 0;
}

.btn-edit {
    color: #007bff; 
}

.btn-delete {
    color: #dc3545; 
}

.btn-edit:hover,
.btn-delete:hover {
    background-color:  #ffc107;
}


.table-striped thead {
    background: #34495E; /* Cambia el color de fondo del encabezado */
    color: #FFFFFF; /* Cambia el color del texto del encabezado */
}


/* Ajustar el ancho de una columna específica */
#tablaVotos th:nth-child(1), /* Ajusta el ancho de la primera columna */
#tablaVotos td:nth-child(1) {
    width: 5px; /* Puedes ajustar el ancho según tus necesidades */
}

/*Poder desplazar el contenido de la celda después de superar cierto espacio. Se modifica en css y en la función que trae los datos en javascript*/
#tablaVotos td:nth-child(6) .contraseña {
    white-space: nowrap; 
	max-width: 45px;
	overflow-x: auto;
}

#tablaVotos td:nth-child(2) .rol {
	white-space: nowrap; 
	max-width: 28px;
	overflow-x: auto;
}

.scrollable-cell {
    max-width: 45px; /* Establece el ancho máximo para la celda */
    overflow-x: auto; /* Agrega una barra de desplazamiento horizontal si el contenido excede el ancho */
}

    
</style>


<body>
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
                                    <button class="btn btn-success" style="background-color: #26a042; color: white; margin-left: 15px;" data-bs-toggle="modal" data-bs-target="#addVotoModal">
                                        <i class="material-icons" style="color: white;">&#xE147;</i> <span>Agregar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <table class="table table-striped" id="tablaVotos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Empresa</th>
                        <th>Representante</th>
                        <th>Presente</th>
                        <th>Representado</th>
                        <th>Voto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="dataVotos">
                    <!-- Aquí se insertarán las filas de la tabla mediante JavaScript -->
                </tbody>
            </table>

        </div>
    </div> 
    <!-- Modal para agregar voto -->
    <div class="modal fade" id="addVotoModal" tabindex="-1" aria-labelledby="addVotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVotoModalLabel">Agregar Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarVoto">
                        <div class="mb-3">
                            <label for="empresa" class="form-label">Empresa</label>
                            <input type="text" name="empresa" id="empresa" class="form-control valid" placeholder="Ingrese el nombre de la empresa" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="representante" class="form-label">Representante</label>
                            <input type="text" name="representante" id="representante" class="form-control valid" placeholder="Ingrese el nombre del representante" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="presente" class="form-label">Presente</label>
                            <input type="text" name="presente" id="presente" class="form-control valid" placeholder="Ingrese el estado de presente" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="representado" class="form-label">Representado</label>
                            <input type="text" name="representado" id="representado" class="form-control valid" placeholder="Ingrese el estado de representado" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="voto" class="form-label">Voto</label>
                            <input type="text" name="voto" id="voto" class="form-control valid" placeholder="Ingrese el voto" autocomplete="off">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="AgregarVoto()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="../JS/empresas.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>


</body>
</html>