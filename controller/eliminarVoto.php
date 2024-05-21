<?php
require_once '../config/conexion.php'; 

if(isset($_POST['id_empresa'])) {
    $idEmpresa = $_POST['id_empresa'];

    // Sentencia para eliminar la entrada en tbl_registro_votos
    $delete_query = "DELETE FROM tbl_registro_votos WHERE id_empresa = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param("i", $idEmpresa);

    if ($stmt_delete->execute()) {
        // Aquí ejecutas la sentencia para actualizar los valores en la tabla votos
        $update_query = "UPDATE votos SET presente = NULL, representado = NULL, voto = NULL WHERE id = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("i", $idEmpresa);

        if ($stmt_update->execute()) {
            echo json_encode(array("status" => "success", "message" => "El voto de la empresa con ID $idEmpresa ha sido eliminado correctamente."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Hubo un error al intentar actualizar el voto en la tabla votos."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Hubo un error al intentar eliminar el registro de la empresa en tbl_registro_votos."));
    }
}
?>
