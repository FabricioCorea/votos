<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Empresas registradas</h1>
        <table class="table table-striped" id="tablaEmpresas">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Empresa</th>
                    <th>Representante</th>
                    <th>Presente</th>
                    <th>Representado</th>
                    <th>Voto</th>
                </tr>
            </thead>
            <tbody id="dataEmpresas">
                <!-- Aquí se insertarán las filas de la tabla mediante JavaScript -->
            </tbody>
        </table>
         
        <select id="Select_empresa" name="Select_empresa" style="width: 100%" class="select2">
                                    <!-- <option value="">Seleccione una empresa</option> -->
                                    
        </select>
    </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="../JS/datos.js"></script>
       <!-- Select con buscador -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>