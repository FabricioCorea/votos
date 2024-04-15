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

$empresas = new Empresas2();

// Obtener las empresas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $resultado = $empresas->obtenerEmpresas();

    if ($resultado) {
        echo json_encode($resultado);
    } else {
        echo json_encode(['mensaje' => 'No se pudieron obtener las empresas']);
    }
}

// Agregar una nueva empresa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si los datos del formulario fueron enviados
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['empresa']) && isset($data['representante'])) {
        $empresa = $data['empresa'];
        $representante = $data['representante'];

        $exito = $empresas->agregarEmpresa($empresa, $representante);

        if ($exito) {
            echo json_encode(['mensaje' => 'Empresa agregada correctamente']);
        } else {
            echo json_encode(['mensaje' => 'Error al agregar la empresa']);
        }
    } else {
        echo json_encode(['mensaje' => 'Faltan datos para agregar la empresa']);
    }
}


// Eliminar una empresa

// Eliminar una empresa
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Verifica si se proporcionó el ID de la empresa a eliminar
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $idEmpresa = $data['id'];

        $exito = $empresas->eliminarEmpresa($idEmpresa);

        if ($exito) {
            echo json_encode(['mensaje' => 'Empresa eliminada correctamente']);
        } else {
            echo json_encode(['mensaje' => 'Error al eliminar la empresa']);
        }
    } else {
        echo json_encode(['mensaje' => 'Falta el ID de la empresa a eliminar']);
    }
}

// Actualizar una empresa
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Verifica si se proporcionaron los datos de la empresa a actualizar
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id']) && isset($data['empresa']) && isset($data['representante'])) {
        $idEmpresa = $data['id'];
        $empresa = $data['empresa'];
        $representante = $data['representante'];

        $exito = $empresas->actualizarEmpresa($idEmpresa, $empresa, $representante);

        if ($exito) {
            echo json_encode(['mensaje' => 'Empresa actualizada correctamente']);
        } else {
            echo json_encode(['mensaje' => 'Error al actualizar la empresa']);
        }
    } else {
        echo json_encode(['mensaje' => 'Faltan datos para actualizar la empresa']);
    }
}




?>