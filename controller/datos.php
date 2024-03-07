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
        require_once '../models/Datos.php'; 

        $votos = new Voto();

        $body = json_decode(file_get_contents("php://input"), true);

        switch($_GET["opc"]){
            case "GetVotos":
                $datos = $votos->get_votos();
                echo json_encode($datos);
            break; 
                    
            case "GetVoto":
                if(isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $datos = $votos->get_voto($id);
                    echo json_encode($datos);
                } else {
                    echo json_encode(array()); // Si no se proporciona el ID, devolver un array vacío
                }
            break;  
        }        
?>