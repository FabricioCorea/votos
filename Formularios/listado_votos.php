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
      <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="../images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
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

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-pPtNaT2zqPRGkCv3rZyfC+Xtctj/eF2gR2GXK0FIKeY5NhZ1V1v/UZA5qETBuTrVbo7uOujcGm3teHZVd/s6JQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://kit.fontawesome.com/a5cebb58e6.js" crossorigin="anonymous"></script>

   </head>

   <!--------------------------------------------------- Estilos --------------------------------------------------->
   <style>
    .tablegra {
    background: #34495E; 
        padding: 1px;
        color: #ffffff   
    }
    .boton {
    background: #34495E; 
    }
    </style>

<!------------------------------------------------------------------------------------------------------------------->

   <!-- body -->
   <body class="main-layout inner_header about_page">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="../images/loading.gif" alt="#" /></div>
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
                              <a href="./indexAdmin.html"><img src="../images/logo-transparente.webp" alt="#" /></a>
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
                                 <a class="nav-link" href="./indexAdmin.html">Inicio</a>
                              
                                </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
               <div class='col-md-5 offset-md-7'>

                        <!--Botón de Generar reportes-->
                        <div class="text-right mb-5"> 
                            <a href="../fpdf/PruebaV.php" target="_blank" class="btn btn-light text-dark"><i class="fas fa-file-pdf"></i> PDF</a>   
                            <a href="../excel/excel2.php" target="_blank" class="btn btn-light text-dark"><i class="fa-solid fa-file-excel"></i> EXCEL</a>       
                        </div>
                    </div>
                </div>
            </div>
      </header>
  <br>
  <br>
  <br>
  <br>
  <br>    
  <br>

   </div>
   </div>

          <!-- Javascript files-->
      <script src="../js/jquery.min.js"></script>
      <script src="../js/popper.min.js"></script>
      <script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="../js/custom.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/helpers.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
      <script src="../js/about_copy.js"></script>
 
      


<!---------------------------------------------------------------------------------------------------------------->      
<?php

$inc = include("../config/conexion.php");

$sql = "
SELECT 'Representante' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
UNION ALL
SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
UNION ALL
SELECT 'Votos' AS Tipo, COUNT(*) AS Total FROM votos WHERE voto = 1
";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "</br>";
    echo "<div class='container-sm mt-5'>";
    echo "<div class='row'>"; 

    // Columna para la tabla
    echo "<div class='col-md-5 offset-md-1'>"; 
    echo "<div class='table-responsive'>";
    echo "<table class='table table-light table-bordered' style='width: 85%; border: 1.5px solid black;'>"; 
    echo "<thead class='tablegra'><tr><th>Tipo</th><th>Total</th></tr></thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $fila_estilo = ($row["Tipo"] === "Votos") ? "style='background-color: #BABBBD;'" : "";

        echo "<tr $fila_estilo>";
        echo "<td>" . $row["Tipo"] . "</td>";
        echo "<td>" . $row["Total"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "</div>"; 

    /// Columna para el botón
    echo "<div class='col-md-6 offset-md-1 mt-3 text-right'>"; 
    echo "<button onclick='document.location.reload();' type='button' class='btn btn-primary boton'> Actualizar <i class='fas fa-sync-alt'></i></button>";
    echo "</div>"; 

    echo "</div>"; 

    // Columna para el canvas
    echo "<div class='col-md-6'>"; 
    echo "<div class='col-md-8 offset-md-2'>"; 
    echo '
    <div style="position: relative; width: 350px; height: 350px;">
        <canvas id="grafico"></canvas>
        <div id="etiquetas" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
    </div>
    ';
    echo "</div>"; 

    echo "</div>"; 
    echo "</div>"; 
    echo "</div>"; 

} else {
    echo "0 resultados";
}
$conn->close();
?>

<!------------------------------------------------------------------------------------------------------------------>
<?php

$conexion = mysqli_connect("localhost", "root", "", "voto");


$sql = "
    SELECT 'Representante' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
    UNION ALL
    SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
";
$resultado = mysqli_query($conexion, $sql);

$categorias = array();
$cantidades = array();
$total = 0;
while ($fila = mysqli_fetch_assoc($resultado)) {
    $total += $fila['Total'];
}

mysqli_data_seek($resultado, 0); 
while ($fila = mysqli_fetch_assoc($resultado)) {
    $categorias[] = $fila['Tipo'];
    $cantidades[] = ($fila['Total'] / $total) * 100;
}
?>

<script>
var ctx = document.getElementById('grafico').getContext('2d');
var grafico = new Chart(ctx, {
    type: 'pie',
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
        responsive: true, 
        maintainAspectRatio: false, 
        plugins: {
            tooltip: {
                enabled: true, 
                callbacks: {
                    label: function(context) {
                        var label = context.label || '';
                        var value = context.formattedValue || '';
                        return value + '%'; 
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>


