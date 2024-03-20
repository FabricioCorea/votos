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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico PHP</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/a5cebb58e6.js" crossorigin="anonymous"></script>
</head>
<body>


<div class='col-md-5 offset-md-6'>
           <!--Botón de Generar reportes-->
           <div class="text-right mb-7"> 
		      <a href="../fpdf/PruebaV.php" target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i> PDF</a>   
            <a href="../fpdf/PruebaH.php" target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i> EXCEL</a>       
            </div>
         </div>
<div class="text-right mb-7"> 
						<a href="fpdf/PruebaV.php" target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i>Generar reportes</a>     
					</div>	
<<<<<<< Updated upstream
    <canvas id="grafico" width="400" height="400"></canvas>
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
                        'rgba(189, 195, 199)',
                        'rgba(244, 208, 63 )'
                    ],
                    borderColor: [
                        'rgba(57, 157, 204)',
                        'rgba(244, 208, 63)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });
=======
                    <div style="position: relative; width: 400px; height: 400px;">
    <canvas id="grafico"></canvas>
    <div id="etiquetas" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
</div>
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
        responsive: false,
        maintainAspectRatio: false,
    }
});

// Obtener los datos del gráfico
var datos = grafico.data.datasets[0].data;
var etiquetas = grafico.data.labels;

// Agregar etiquetas permanentes
var etiquetasContainer = document.getElementById('etiquetas');
for (var i = 0; i < datos.length; i++) {
    var etiqueta = document.createElement('div');
    etiqueta.textContent = etiquetas[i] + ": " + datos[i];
    etiqueta.style.marginBottom = "5px";
    etiquetasContainer.appendChild(etiqueta);
}
>>>>>>> Stashed changes
    </script>
</body>
</html>
<?php
// Paso 5: Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
