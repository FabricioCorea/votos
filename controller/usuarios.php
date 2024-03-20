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
        require_once '../models/Usuarios.php'; 

        if(isset($_SESSION['usuario'])) {
            // El usuario está en sesión
            $creadoPor  = $_SESSION['usuario'];
        } 

        $usuarios = new Usuario();

        $body = json_decode(file_get_contents("php://input"), true);

        switch($_GET["opc"]){
            case "GetUsuarios":
                $datos = $usuarios->get_usuarios();
                echo json_encode($datos);
            break; 
            case "InsertUsuario":
                $rol=$body['rolSelect'];
                $usuario=$body['usuario'];
                $nombre=$body['nombre'];
                $estado=$body['estadoSelect'];
                $contrasena=$body['contraseña'];
                $confirmcontrasena=$body['confirmContraseña'];
                
                // Función para encriptar contraseña
                function encriptar($password) {
                    $encriptada = hash('sha256', $password);
                    return $encriptada;
                }
                //Variable que almacena la contraseña encriptada
                $contrasenaEncriptada = encriptar($contrasena);
                $selectUsuario=$usuarios->verificar_usuario($usuario);

               if (count($selectUsuario)>0) {
                    $arrResponse = array("status" => false, "msg" => 'El usuario ya existe. Ingrese un usuario distinto');
                }else{
               
                    $datos=$usuarios->insert_usuario($rol,$usuario,$nombre,$estado,$contrasenaEncriptada, $creadoPor['usuario']);

                    if ($datos>0) {
                        
                        $arrResponse = array("status" => true, "msg" => 'Usuario agregado con éxito');
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            break;
            case "DeleteUsuario":
                $id_usuario = $_POST['id_usuario'];
            
                // Verificar si el usuario existe antes de eliminarlo
                $usuario_existente = $usuarios->verificar_usuario_por_id($id_usuario);
            
                if ($usuario_existente) {
                    // Si el usuario existe, intentar eliminarlo
                    $eliminado = $usuarios->delete_usuario($id_usuario);
            
                    if ($eliminado) {
                        $arrResponse = array("status" => true, "msg" => 'Usuario eliminado con éxito');
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'No se pudo eliminar el usuario');
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'El usuario no existe');
                }
            
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                break;                       
            case "GetRoles":
                $datos=$usuarios->get_roles();
                echo json_encode($datos);
            break;
        }        
?>