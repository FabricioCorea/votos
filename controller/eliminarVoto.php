<?php
require_once '../config/conexion.php'; 

if(isset($_POST['id_empresa'])) {
    $idEmpresa = $_POST['id_empresa'];

    // Sentencia para eliminar el voto
    $query = "UPDATE votos SET presente = NULL, representado = NULL, voto = NULL WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idEmpresa);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "El voto de la empresa con ID $idEmpresa ha sido eliminado correctamente."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Hubo un error al intentar eliminar el voto."));
    }
}
?>
