<?php
session_start(); // Iniciar la sesión

$varsesion = $_SESSION['usuario'];
if($varsesion == null || $varsesion ==''){
    header("location: ../Formularios/login.php");
    die();
}
?>
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
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
    <link rel="stylesheet" type="text/css" href="../css/stilo.css">
    <link rel="stylesheet" type="text/css" href="../css/listado_votos.css">

</head>
<!-- body -->
<body class="main-layout inner_header about_page">

    <nav class="nav1">
        <div class="wrapper">
            <div class="logoIMG">
            <a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1' || $_SESSION['usuario']['id_rol'] == '0') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">
                    <img class="small-image" src="../images/logo-transparente.webp" alt="#" />
                </a>
            </div>

            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links1">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1' || $_SESSION['usuario']['id_rol'] == '0') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">INICIO</a></li>
                <li><a href="registrarVoto.php">REGISTRAR VOTO</a></li>
                <li>
                    <a href="#" class="desktop-item">
                        <span class="icon-right">
                            <i class="fas fa-user"></i>
                        </span>
                        <?php echo $_SESSION['usuario']['usuario']; ?>
                    </a>
                </li>
                <li><a href="logout.php"> <i title="Cerrar Sesión" class="fas fa-sign-out-alt"></i></a><span class="sr-only">Cerrar Sesión&gt;</span></a></li>
        </div>
        </nav>
        <br><br><br><br><br><br><br>
        <div class="contenedor-grid">
            <div class="izquierda">
                <div class="text-bg">
                    <h1>Votos Registrados</h1>
                </div>
            </div>
            <div class="derecha">
                <a href="../fpdf/PruebaV.php" target="_blank" class="btn btn-light text-dark"><i class="fas fa-file-pdf"></i> PDF</a>
                <a href="../excel/excel.php" target="_blank" class="btn btn-light text-dark"><i class="fa-solid fa-file-excel"></i> EXCEL</a>
            </div>
        </div>
        </div>
        </div>

        <!-- Javascript files-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
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
        
        <script src="../JS/resetear_votos.js"></script>

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

        $total = 0;

        if ($result->num_rows > 0) {
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
                $total += $row["Total"];

                echo "<tr $fila_estilo>";
                echo "<td>" . $row["Tipo"] . "</td>";
                echo "<td>" . $row["Total"] . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
            echo "</div>";

                    /// Columna para el botón
  
            // Aquí añadimos la lógica para mostrar u ocultar el botón según el rol del usuario
            if ($_SESSION['usuario']['id_rol'] == '1') {
                echo "<div class='col-md-4 offset-md-1 mt-3 text-right'>";
                echo "<button onclick='document.location.reload();' type='button' class='btn btn-primary boton'> Refrescar <i class='fas fa-sync-alt'></i></button>";
                echo "</div>";
                echo "<div class='col-md-3 offset-md-1 mt-3 text-right'>";
                echo '<button onclick="resetVotos();" type="button" class="btn btn-danger boton"> Reiniciar conteo <i class="fas fa-redo-alt"></i></button>';
                echo "</div>";
            } else if ($_SESSION['usuario']['id_rol'] == '2') {
                echo "<div class='col-md-4 offset-md-3 mt-3 text-right'>";
                echo "<button onclick='document.location.reload();' type='button' class='btn btn-primary boton'> Refrescar <i class='fas fa-sync-alt'></i></button>";
                echo "</div>";
            }
            echo "</div>";

            // Columna para el canvas
            echo "<div class='col-md-6'>";
            echo "<div class='col-md-8 offset-md-2'>";
            if ($total != 0) {
                echo '
                <div style="position: relative; width: 350px; height: 350px;">
                    <canvas id="grafico"></canvas>
                    <div id="etiquetas" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                </div>
                ';
            } else {
                echo ' <br>';
                echo ' <br>';
                echo '<p>Cuando haya votos registrados, en este apartado se mostrará un gráfico reflejando el porcentaje de votos según el tipo (Representante o Representado).</p>';
            }
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
            if ($total != 0) {
                $cantidades[] = ($fila['Total'] / $total) * 100;
            } else {
                $cantidades[] = 0;
            }
        }

        ?>

        <!-------------------------------SCRIPT PARA GRÁFICO----------------------------------->
        <?php if ($total != 0) { ?>
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
        <?php } ?>

</body>

</html>