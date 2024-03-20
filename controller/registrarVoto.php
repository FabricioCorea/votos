<?php
require_once '../config/conexion.php'; 

$selectOptions = ""; // Declarar la variable para almacenar las opciones

$query = "SELECT * FROM votos ORDER BY id";

if (isset($_POST['id_empresa'])) {
    $idEmpresa = $conn->real_escape_string($_POST['id_empresa']);
    $query = "SELECT * FROM votos WHERE id = '" . $idEmpresa . "'";
}

$buscarEmpresas = $conn->query($query);

if ($buscarEmpresas->num_rows > 0) {
    while ($filaEmpresa = $buscarEmpresas->fetch_assoc()) {
        $selectOptions .= '<li data-id="' . htmlspecialchars($filaEmpresa['id']) . '">' . htmlspecialchars($filaEmpresa['id']) . ' - ' . htmlspecialchars($filaEmpresa['empresa']) . ' - ' . htmlspecialchars($filaEmpresa['representante']) . '</li>';
    }
} else {
    $selectOptions = "<li>No se encontró la empresa con el ID proporcionado.</li>";
}

// Verificar si se ha enviado el formulario de registro de voto
if (isset($_POST['id_empresa']) && isset($_POST['subject'])) {
    $id = strip_tags($_POST["id_empresa"]);
    $presente = strip_tags($_POST["subject"]);

    // Consulta para verificar si ya existe un voto para la empresa
    $query = "SELECT * FROM votos WHERE id = '$id' AND voto > 0";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Agregar el ID al mensaje si el voto ya ha sido registrado anteriormente
        echo json_encode(array("status" => "error", "message" => 'El voto para la empresa con ID ' . $id . ' ya ha sido registrado anteriormente.'));
    } else {
        // Consulta para actualizar la base de datos con el nuevo voto
        $query2 = "SELECT * FROM votos WHERE id = '$id'";
        $result2 = $conn->query($query2);
    
        if ($result2->num_rows > 0) {
            $row_cnt2 = $result2->num_rows;
    
            $campoActualizar = ""; // Variable que almacena el campo según la opción capturada
            if ($presente === "REPRESENTANTE") {
                $campoActualizar = "presente";
            } elseif ($presente === "REPRESENTADO") {
                $campoActualizar = "representado";
            }
    
            $meter = "UPDATE votos SET voto = 1, $campoActualizar = '$presente' WHERE id = '$id'";
            
            if ($conn->query($meter) && $row_cnt2 > 0) {
                echo json_encode(array("status" => "success", "message" => 'El voto para la empresa con ID ' . $id . ' se ha registrado correctamente.'));
            } else {
                echo json_encode(array("status" => "error", "message" => "Hubo un error al registrar el voto para la empresa con ID $id: " . $conn->error));
            }
        }
    }
    
} else {
    echo $selectOptions; // Mostrar la lista de opciones si no se envió el formulario de registro de voto
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
