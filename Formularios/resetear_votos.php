<?php
include("../config/conexion.php");
$sql = "UPDATE votos SET presente = NULL, representado =NULL, voto = NULL";
if ($conn->query($sql) === TRUE) {
    echo "Los votos se han reiniciado correctamente.";
} else {
    echo "Error al reiniciar los votos: " . $conn->error;
}
$conn->close();
?>
