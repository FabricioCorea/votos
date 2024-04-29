<?php
// Conectar a la base de datos
include("../config/conexion.php");

// Lógica para reiniciar los votos (por ejemplo, establecer todos los votos a cero)
$sql = "UPDATE votos SET presente = NULL, representado =NULL, voto = NULL";
if ($conn->query($sql) === TRUE) {
    echo "Los votos se han reiniciado correctamente.";
} else {
    echo "Error al reiniciar los votos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
