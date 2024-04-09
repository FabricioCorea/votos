<?php
require_once '../models/model.php';

$model = new Model();

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$porPagina = 8000;

$registros = $model->obtenerRegistros($busqueda, $pagina, $porPagina);
$totalRegistros = $model->contarRegistros($busqueda);
$paginas = ceil($totalRegistros / $porPagina);

require_once '../Formularios/view.php'; // Ruta relativa a la ubicación del archivo index.php
?>
