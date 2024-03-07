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
      <link rel="stylesheet" href="css/style.css">
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
                              <li class="nav-item d_none">
                                 <a class="nav-link" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>

                              </li>
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

          <!-- Javascript files-->
  <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>



<div class="col-md-8">
    <div class="row">
        <!-- Contenedor para el gráfico -->
      
        <!-- Contenedor para la tabla -->
        
 <?php

 $inc = include("./config/conexion.php");

$sql = "
    SELECT 'Presente' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
    UNION ALL
    SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
    UNION ALL
    SELECT 'Voto' AS Tipo, COUNT(*) AS Total FROM votos WHERE voto = 1
";

$result = $conn->query($sql);

// Paso 3: Mostrar los resultados en una tabla HTML
if ($result->num_rows > 0) {

   echo "<table class='tableizer-table' border='1'>";
   echo "<tr class='tableizer-firstrow'><th>Tipo</th><th>Total</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Tipo"]. "</td><td>" . $row["Total"]. "</td></tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "0 resultados";
}

// Cerrar la conexión
$conn->close();
?>
         <div class="col-md-8 ">
            <div style="width: 100%; height: 400px;">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>
<?php

// Datos para el gráfico
$labels = ["Presente", "Representado"];
$data = [49,56]; // Aquí deberías obtener los datos de tu base de datos o de otra fuente

// Genera el código JavaScript para inicializar el gráfico con los datos
echo "<script>";
echo "var ctx = document.getElementById('myChart').getContext('2d');";
echo "var myChart = new Chart(ctx, {";
echo "    type: 'bar',";
echo "    data: {";
echo "        labels: " . json_encode($labels) . ",";
echo "        datasets: [{";
echo "            label: 'Cantidad',";
echo "            data: " . json_encode($data) . ",";
echo "            backgroundColor: [";
echo "                'rgba(255, 99, 132, 0.6)',";
echo "                'rgba(54, 162, 235, 0.6)',";
echo "                'rgba(255, 206, 86, 0.6)'";
echo "            ],";
echo "            borderColor: [";
echo "                'rgba(255, 99, 132, 1)',";
echo "                'rgba(54, 162, 235, 1)',";
echo "                'rgba(255, 206, 86, 1)'";
echo "            ],";
echo "            borderWidth: 1";
echo "        }]";
echo "    },";
echo "    options: {";
echo "        scales: {";
echo "            y: {";
echo "                beginAtZero: true";
echo "            }";
echo "        }";
echo "    }";
echo "});";
echo "</script>";
?>
      