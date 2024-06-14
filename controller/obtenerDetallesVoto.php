<?php
session_start(); // Iniciar la sesión

require_once '../config/conexion.php'; 

// Procesar solicitud de obtener detalles del voto
if(isset($_POST['id_empresa'])) {
    $idEmpresa = $conn->real_escape_string($_POST['id_empresa']);

    // Consulta para obtener los detalles del voto desde la tabla votos y tbl_registro_votos
    $queryDetallesVoto = "SELECT v.id, v.empresa, v.presente, v.representado, r.id_usuario, r.fecha_registro, u.usuario as usuario_registrador,
                        CASE 
                            WHEN v.presente IS NULL THEN 'REPRESENTADO' 
                            WHEN v.representado IS NULL THEN 'REPRESENTANTE' 
                            WHEN v.presente = 0 THEN 'REPRESENTANTE' 
                            WHEN v.representado = 0 THEN 'REPRESENTADO'
                            ELSE 'CONDICIÓN DESCONOCIDA'
                        END AS condicion_votante,
                        CASE 
                            WHEN v.presente IS NULL THEN r.representado_por
                            WHEN v.representado IS NULL THEN v.representante
                        END AS nombre_persona
                        FROM votos v 
                        INNER JOIN tbl_registro_votos r ON v.id = r.id_empresa 
                        INNER JOIN tbl_usuarios u ON r.id_usuario = u.id_usuario
                        WHERE v.id = '$idEmpresa'";
    $resultDetallesVoto = $conn->query($queryDetallesVoto);

    if ($resultDetallesVoto->num_rows > 0) {
        $filaDetallesVoto = $resultDetallesVoto->fetch_assoc();

        // Construir el mensaje con los detalles del voto
        $message = "<div style='text-align: left;'>"; 
        $message .= "<b>ID de la empresa:</b> " . $filaDetallesVoto['id'] . "<br>";
        $message .= "<b>Nombre de la empresa:</b> " . $filaDetallesVoto['empresa'] . "<br>";
        $message .= "<b>Condición del votante:</b> " . $filaDetallesVoto['condicion_votante'] . "<br>";
        
        // Si el votante es un REPRESENTANTE, mostramos su nombre
        if($filaDetallesVoto['condicion_votante'] == 'REPRESENTANTE') {
            $message .= "<b>Representante:</b> " . $filaDetallesVoto['nombre_persona'] . "<br>";
        }
        // Si el votante es un REPRESENTADO, mostramos el representante
        elseif($filaDetallesVoto['condicion_votante'] == 'REPRESENTADO') {
            $message .= "<b>Representado por:</b> " . $filaDetallesVoto['nombre_persona'] . "<br>";
        }
        
        $message .= "<b>Voto registrado por:</b> " . $filaDetallesVoto['usuario_registrador'] . "<br>";
        $message .= "<b>Fecha y hora de registro:</b> " . $filaDetallesVoto['fecha_registro'] . "<br>";
        $message .= "</div>"; 

        echo json_encode(array("status" => "success", "message" => $message));
    } else {
        echo json_encode(array("status" => "error", "message" => "No se encontraron detalles del voto para la empresa con el ID proporcionado."));
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
