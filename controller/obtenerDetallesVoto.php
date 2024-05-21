<?php
session_start(); // Iniciar la sesión

require_once '../config/conexion.php'; 

// Procesar solicitud de obtener detalles del voto
if(isset($_POST['id_empresa'])) {
    $idEmpresa = $conn->real_escape_string($_POST['id_empresa']);

    // Consulta para obtener los detalles del voto desde la tabla tbl_registro_votos
    $queryDetallesVoto = "SELECT v.id, v.empresa, v.presente, v.representado, r.id_usuario, r.fecha_registro, u.usuario as usuario_registrador 
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
        $message .= "<b>Condición del votante:</b> ";

        // Determinar la condición del votante
        if ($filaDetallesVoto['presente'] === null) {
            $message .= 'Representado';
        } elseif ($filaDetallesVoto['representado'] === null) {
            $message .= 'Representante';
        } elseif ($filaDetallesVoto['presente'] == 0) {
            $message .= 'Representante';
        } elseif ($filaDetallesVoto['representado'] == 0) {
            $message .= 'Representado';
        } else {
            $message .= 'Condición desconocida';
        }
        $message .= "<br>";
        $message .= "<b>Usuario que registró el voto:</b> " . $filaDetallesVoto['usuario_registrador'] . "<br>";
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
