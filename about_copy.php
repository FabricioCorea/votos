<!DOCTYPE html>
<html lang="en">

   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Votos</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="./css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

      <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400" rel="stylesheet" type="text/css">
      
      <!--   CSS for 147 Colors   -->
      <link href="http://www.colorname.xyz/style.css" rel="stylesheet" type="text/css"> 
          
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

      <!--   Librería para gráficos    -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   </head>


   <!-- body -->
   <body class="main-layout inner_header about_page">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header_listado">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="images/logo-transparente.webp" alt="#" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">

                                 <a class="nav-link" href="index.html">Inicio</a>

                              </li>
                              <!--<li class="nav-item d_none">
                                 <a class="nav-link" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>

                              </li>-->
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header inner -->
      <!-- end header -->
  <br>
  <br>
  <br>

  
<!-- <main class="container">

   <div class="row mt-5">
      <div class="grafico-container">
      <canvas id="grafico" width="400" height="400"></canvas>
</main> -->
   </div>
   </div>

          <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/helpers.min.js"></script>
      <script src="./js/about_copy.js"></script>
   

       
<style>

.tablegra {
   background: #34495E; /* Color de fondo de la primera fila */
     padding: 1px;
     color: #ffffff   
   }

</style>

 <?php

 $inc = include("./config/conexion.php");

$sql = "
    SELECT 'Presente' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
    UNION ALL
    SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
    UNION ALL
    SELECT 'Voto' AS Tipo, COUNT(*) AS Total FROM votos WHERE voto = 1
";

// $result = $conn->query($sql);

// // Paso 3: Mostrar los resultados en una tabla HTML
// if ($result->num_rows > 0) {

//    echo "<table class='table tableizer-table  ' border='2'>";
//    echo "<tr class='rosado    '><th>Tipo</th><th>Total</th></tr>";
//     while($row = $result->fetch_assoc()) {
//         echo "<tr><td>" . $row["Tipo"]. "</td><td>" . $row["Total"]. "</td></tr>";
//     }
//     echo "</table>";
//     echo "</div>";
// } else {
//     echo "0 resultados";
// }

$result = $conn->query($sql);

// Paso 3: Mostrar los resultados en una tabla HTML
if ($result->num_rows > 0) {
   echo "</br>";
   echo "</br>";
   echo "</br>";
   echo "</br>";
   echo "<div class='container-sm mt-5'>";
   echo "<div class='row'>"; // Agregar una fila
   
   // Columna para la tabla
   echo "<div class='col-md-5 offset-md-1'>"; // Tamaño medio, desplazamiento 1 columna hacia la izquierda
   echo "<div class='table-responsive'>";
   echo "<table class='table table-light  table-bordered' style='width: 85%;'>"; // Ancho del 100%
   echo "<thead class='tablegra'><tr><th>Tipo</th><th>Total</th></tr></thead>";
   echo "<tbody>";

   while($row = $result->fetch_assoc()) {
       echo "<tr><td>" . $row["Tipo"]. "</td><td>" . $row["Total"]. "</td></tr>";
   }
   
   echo "</tbody></table>";
   echo "</div>"; // Cerrar la tabla
   echo "</div>"; // Cerrar la columna para la tabla
   
   // Columna para el canvas
   echo "<div class='col-md-6'>"; // Tamaño medio
   echo "<div class='col-md-8 offset-md-2'>"; // Desplazamiento a la derecha y tamaño de columna más pequeño
   echo "<canvas id='grafico' width='400' height='400'></canvas>"; // Agregar el canvas
   echo "</div>"; // Cerrar la columna para el canvas
   
   echo "</div>"; // Cerrar la columna para el canvas
   echo "</div>"; // Cerrar la fila
   echo "</div>"; // Cerrar el contenedor
   
   // Agregar aquí el contenido de la fila de Bootstrap si es necesario

} else {
    echo "0 resultados";
}



// Cerrar la conexión
$conn->close();
?>




<?php
// Paso 1: Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "voto");

// Paso 2: Consultar los datos
$sql = "
    SELECT 'Presente' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
    UNION ALL
    SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
";
$resultado = mysqli_query($conexion, $sql);

// Paso 3: Procesar los datos
$categorias = array();
$cantidades = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    $categorias[] = $fila['Tipo'];
    $cantidades[] = $fila['Total'];
}

// Paso 4: Generar el gráfico
?>

<script>
        var ctx = document.getElementById('grafico').getContext('2d');
        var grafico = new Chart(ctx, {
            type: 'pie', // Cambio a tipo de gráfico de pastel
            data: {
                labels: <?php echo json_encode($categorias); ?>,
                datasets: [{
                    label: 'Cantidad',
                    data: <?php echo json_encode($cantidades); ?>,
                    backgroundColor: [
                        'rgba(52, 73, 94)', 
                        'rgba(241, 189, 20)'
                    ],
                    borderColor: [
                        'rgba(178, 186, 187)',
                        'rgba(253,247,232)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });
    </script>


</body>
</html>