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

if (isset($_SESSION['usuario'])) {
    // El usuario está en sesión
    $creadoPor = $_SESSION['usuario'];
}

$votos = new Voto();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["opc"]) {
    case "GetVotos":
        $datos = $votos->get_votos();
        echo json_encode($datos);
        break; 
    case "InsertVoto":
        $empresa = $body['empresa'];
        $representante = $body['representante'];
        $presente = $body['presente'];
        $representado = $body['representado'];
        $voto = $body['voto'];

        $datos = $votos->insert_voto($empresa, $representante, $presente, $representado, $voto);

        if ($datos > 0) {
            $arrResponse = array("status" => true, "msg" => 'Voto agregado con éxito');
        } else {
            $arrResponse = array("status" => false, "msg" => 'Error al agregar el voto');
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        break;
    case "DeleteVoto":
        $id_voto = $_POST['id_voto'];
        
        // Verificar si el voto existe antes de eliminarlo
        $voto_existente = $votos->verificar_voto_por_id($id_voto);
        
        if ($voto_existente) {
            // Si el voto existe, intentar eliminarlo
            $eliminado = $votos->delete_voto($id_voto);
            
            if ($eliminado) {
                $arrResponse = array("status" => true, "msg" => 'Voto eliminado con éxito');
            } else {
                $arrResponse = array("status" => false, "msg" => 'No se pudo eliminar el voto');
            }
        } else {
            $arrResponse = array("status" => false, "msg" => 'El voto no existe');
        }
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        break;                       
}
?>
