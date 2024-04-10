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
            hover-bg: #e9ecef;
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
                                    <button class="btn btn-success" style="background-color: #26a042; color: white; margin-left: 15px;" data-bs-toggle="modal" data-bs-target="#addVotoModal">
                                        <i class="material-icons" style="color: white;">&#xE147;</i> <span>Agregar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <select id="pageSize" onchange="changePageSize()" class="select-k select-c form-select-c">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
            <br>
    <table id="tablaEmpresas" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Representante</th>
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
    <script>
        var empresas = []; // Aquí se almacenarán todas las empresas obtenidas

        // Función para mostrar las empresas según la página actual y el tamaño de página
        function showPage(pageNumber, pageSize) {
            var startIndex = (pageNumber - 1) * pageSize;
            var endIndex = startIndex + pageSize;
            var currentPageData = empresas.slice(startIndex, endIndex);

            var listaEmpresas = document.getElementById('listaEmpresas');
            listaEmpresas.innerHTML = ''; // Limpiar la tabla antes de agregar las filas

            currentPageData.forEach(function(empresa) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + empresa.id + '</td>' +
                                '<td>' + empresa.empresa + '</td>' +
                                '<td>' + empresa.representante + '</td>';
                listaEmpresas.appendChild(row);
            });

            // Actualizar el número de página visible
            document.getElementById('pageNumber').innerText = pageNumber;
        }

        // Función para cambiar al página anterior
        function previousPage() {
            var pageNumber = parseInt(document.getElementById('pageNumber').innerText);
            if (pageNumber > 1) {
                showPage(pageNumber - 1, parseInt(document.getElementById('pageSize').value));
            }
        }

        // Función para cambiar a la página siguiente
        function nextPage() {
            var pageNumber = parseInt(document.getElementById('pageNumber').innerText);
            var pageSize = parseInt(document.getElementById('pageSize').value);
            var totalPages = Math.ceil(empresas.length / pageSize);
            if (pageNumber < totalPages) {
                showPage(pageNumber + 1, pageSize);
            }
        }

        // Función para cambiar el tamaño de página
        function changePageSize() {
            var pageSize = parseInt(document.getElementById('pageSize').value);
            showPage(1, pageSize);
        }

        // Obtener las empresas mediante una solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../controller/empresas2.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                empresas = JSON.parse(xhr.responseText);
                showPage(1, parseInt(document.getElementById('pageSize').value)); // Mostrar la primera página al cargar
            } else {
                console.error('Error al obtener las empresas');
            }
        };
        xhr.send();
    </script>


 <!-- JavaScript -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
   

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
