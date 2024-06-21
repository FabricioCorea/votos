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
require_once '../models/Empresas.php'; 

$votoModelo = new Voto(); // Instancia del modelo

// Obtener los votos (empresas)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $resultado = $votoModelo->obtenerVotos(); 

    if ($resultado) {
        echo json_encode($resultado);
    } else {
        echo json_encode(['mensaje' => 'No se pudieron obtener los votos']); 
    }
}

// Agregar una nueva empresa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si los datos del formulario fueron enviados
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id']) && isset($data['empresa']) && isset($data['representante'])) {
        $id = $data['id'];
        $empresa = $data['empresa'];
        $representante = $data['representante'];

        // Llama al método para agregar empresa del modelo
        $exito = $votoModelo->agregarEmpresa($id, $empresa, $representante);

        if ($exito) {
            echo json_encode(['mensaje' => 'Empresa agregada correctamente']);
        } else {
            echo json_encode(['mensaje' => 'La empresa ya ha sido agregada']);
        }
    } else {
        echo json_encode(['mensaje' => 'Faltan datos para agregar la empresa']);
    }
}


// Eliminar una empresa
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Verifica si se proporcionó el ID de la empresa a eliminar
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $idEmpresa = $data['id'];

        // Llama al método para eliminar empresa del modelo
        $exito = $votoModelo->eliminarEmpresa($idEmpresa);

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
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id']) && isset($data['empresa']) && isset($data['representante'])) {
        $idEmpresa = $data['id'];
        $empresa = $data['empresa'];
        $representante = $data['representante'];

        // Llama al método para actualizar empresa del modelo
        $exito = $votoModelo->actualizarEmpresa($idEmpresa, $empresa, $representante);

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
