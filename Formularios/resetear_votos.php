<?php
include("../config/conexion.php");

// Eliminar todos los votos de la tabla tbl_registro_votos
$delete_query = "DELETE FROM tbl_registro_votos";
if ($conn->query($delete_query) === TRUE) {
    // Reiniciar los votos en la tabla votos
    $update_query = "UPDATE votos SET presente = NULL, representado = NULL, voto = NULL";
    if ($conn->query($update_query) === TRUE) {
        echo "Los votos se han reiniciado correctamente.";
    } else {
        echo "Error al reiniciar los votos: " . $conn->error;
    }
} else {
    echo "Error al eliminar los votos de la tabla tbl_registro_votos: " . $conn->error;
}

$conn->close();
?>
