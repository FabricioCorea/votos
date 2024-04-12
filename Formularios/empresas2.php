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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            margin-top: 10px;
            float: right;
            margin: 0 0 5px;
            justify-content: right;
        }
        .pagination button {
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
            border-width: 1px;
            border-color: #dee2e6;

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
            padding: 20px 15px;
            border-radius: 3px;
            min-width: 1280px;
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .table-title {        
            padding-bottom: 15px;
            background: #34495E;
            color: #FFFFFF;
            padding: 16px 30px;
            min-width: 100%;
            margin: -2px -2px 30px;
            border-radius: 3px 3px 0 0;
        }
        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
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
            background: #34495E;
            color: #FFFFFF; 
        }

        .scrollable-cell {
            max-width: 45px; 
            overflow-x: auto; 
        }
        .busqueda_input{
            margin-bottom: 20px;
        }

        .select-c{
            padding-top: .25rem;
            padding-bottom: .25rem;
            padding-left: .5rem;
            font-size: .875rem;
            border-radius: .25rem;
        }
 

        .form-select-c {
            display: block;
            width: 6%;
            padding: .1.5rem 0.25rem .1.5rem .75rem;
            -moz-padding-start: calc(0.75rem - 3px);
            font-size: -5rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-image: url('../images/flecha.jpg');
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 14px 10px;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
}

/* Ajustar el ancho de una columna específica */
#tablaEmpresas th:nth-child(1), /* Ajusta el ancho de la primera columna */
#tablaEmpresas td:nth-child(1) {
    width: 40px; /* Puedes ajustar el ancho según tus necesidades */
}


/* Ajustar el ancho de una columna específica */
#tablaEmpresas th:nth-child(3), /* Ajusta el ancho de la primera columna */
#tablaEmpresas td:nth-child(3) {
    width: 400px; /* Puedes ajustar el ancho según tus necesidades */
}



/* Ajustar el ancho de una columna específica */
#tablaEmpresas th:nth-child(2), /* Ajusta el ancho de la primera columna */
#tablaEmpresas td:nth-child(2) {
    width: 700px; /* Puedes ajustar el ancho según tus necesidades */
}


</style>
</head>



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
                                    <button class="btn btn-success" style="background-color: #26a042; color: white; margin-left: 15px;" data-bs-toggle="modal" data-bs-target="#addEmpresaModal">
                                        <i class="material-icons" style="color: white;">&#xE147;</i> <span>Agregar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <label for="pageSize" style="display: inline-block; margin-right: 5px;">Mostrar</label>
            <select id="pageSize" onchange="changePageSize()" class="select-k select-c form-select-c" style="display: inline-block; margin-right: 5px;">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span style="display: inline-block;">registros</span>


            <br>
            <br>


            <table id="tablaEmpresas" class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>Representante</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="listaEmpresas"></tbody>
    </table>

    <div class="pagination">
    <button onclick="previousPage()">Anterior</button>
    <span id="pageNumber">1</span>
    <button onclick="nextPage()">Siguiente</button>
</div>

</div>  
</div>

   <!-- Modal para agregar usuario -->
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
                            <label for="empresaModal" class="form-label">Empresa</label>
                            <input type="text" name="empresa" id="empresaModal" class="form-control valid ValidEmpresa" onpaste="return false;" placeholder="Ingrese el nombre de la empresa" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="representanteModal" class="form-label">Representante</label>
                            <input type="text" name="representante" id="representanteModal" class="form-control valid ValidRepresentante" onpaste="return false;" placeholder="Ingrese el nombre del Representante" autocomplete="off">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="AgregarEmpresa()">Guardar</button>
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


