<?php
$servidor = "localhost";
$user = "root";
$pass = "";
$database = "voto";

$conn = mysqli_connect($servidor, $user, $pass, $database);

// Verificar la conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>