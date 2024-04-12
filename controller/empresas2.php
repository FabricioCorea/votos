<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../config/conexionPDO.php'; 
require_once '../models/Empresas2.php'; 

if (isset($_SESSION['usuario'])) {
    // El usuario está en sesión
    $creadoPor = $_SESSION['usuario'];
}

// Obtener las empresas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $empresas = new Empresas2();
    $resultado = $empresas->obtenerEmpresas();

    if ($resultado) {
        // Envía la respuesta como JSON
        echo json_encode($resultado);
    } else {
        // Manejar el caso en el que no se puedan obtener las empresas
        echo json_encode(array('mensaje' => 'No se pudieron obtener las empresas'));
    }

    // Agregar una nueva empresa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los datos del formulario fueron enviados
    if(isset($_POST['empresa']) && isset($_POST['representante'])) {
        $empresa = $_POST['empresa'];
        $representante = $_POST['representante'];

        $nuevaEmpresa = new Empresas2();
        $exito = $nuevaEmpresa->agregarEmpresa($empresa, $representante);

        if ($exito) {
            echo json_encode(array('mensaje' => 'Empresa agregada correctamente'));
        } else {
            echo json_encode(array('mensaje' => 'Error al agregar la empresa'));
        }
    } else {
        echo json_encode(array('mensaje' => 'Faltan datos para agregar la empresa'));
    }

    }
}
?>
