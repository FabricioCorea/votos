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
    <style>
        .container {
            display: flex;
            justify-content: flex-start;
        }

        #id_empresa, .lista-resultados {
            width: 500px; /* Ancho fijo */
        }

        .contenedor {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        #resultado_empresa {
            width: 300px; /* Hacemos que la lista de resultados tenga el mismo ancho que el campo de búsqueda */
        }

        .lista-resultados {
            list-style-type: none;
            padding: 0;
            margin: 0;
            max-height: 200px; /* Just an example, adjust as needed */
            overflow-y: auto; /* Add scrollbar if needed */
        }
        .lista-resultados li {
            width: 100%; /* Hacemos que cada elemento de la lista de resultados tenga el mismo ancho que la lista */
            padding: 8px;
            margin: 2px;
            background-color: #1E2A4A; /* Azul oscuro */
            color: white; /* Letras blancas */
            cursor: pointer;
        }
        .lista-resultados li:hover {
            background-color: #2B3E6B; /* Azul oscuro más claro al pasar el cursor */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="contenedor">
        <input type="text" id="id_empresa" placeholder="ID de la empresa">

        <!-- Elemento donde se mostrarán los resultados -->
        <div id="resultado_empresa">
            <ul id="lista_resultados" class="lista-resultados">
                <!-- Aquí se mostrarán los resultados -->
            </ul>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script src="../JS/Votos.js"></script>
</body>
</html>