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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
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
    </script>
</body>
</html>
<?php
// Paso 5: Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
