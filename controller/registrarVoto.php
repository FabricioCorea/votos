<?php
session_start(); // Iniciar la sesión

$varsesion = $_SESSION['usuario'];
if($varsesion == null || $varsesion ==''){
    header("location: ../Formularios/login.php");
    die();
}

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
        $idEmpresa = $filaEmpresa['id'];
        $empresaNombre = htmlspecialchars($filaEmpresa['empresa']);
        $representante = htmlspecialchars($filaEmpresa['representante']);
        
        // Verificar si la empresa ya ha registrado su voto
        $queryVoto = "SELECT * FROM votos WHERE id = '$idEmpresa' AND voto > 0";
        $resultVoto = $conn->query($queryVoto);

        if ($resultVoto->num_rows > 0) {
            // Si ya hay registro de voto, mostrar mensaje de empresa que ya votó
            $selectOptions .= "<li>La empresa con el ID $idEmpresa ya registró su voto. <br>
            <button class='btn btn-delete ver_voto_btn' style='background-color: #3085d6; color: white; margin-left: 15px;' data-id='$idEmpresa'>
                <span>Ver voto</span>
            </button>
            </li>";
        } else {
            // Si no hay registro de voto, mostrar opción para votar
            $selectOptions .= "<li data-id='$idEmpresa'>$idEmpresa - $empresaNombre - $representante</li>";
        }
    }
} else {
    $selectOptions = "<li>No se encontró la empresa con el ID proporcionado.</li>";
}

// Verificar si se ha enviado el formulario de registro de voto
if (isset($_POST['id_empresa']) && isset($_POST['subject'])) {
    $id = strip_tags($_POST["id_empresa"]);
    $presente = strip_tags($_POST["subject"]);
    
    // Capturar el valor del campo representado_por, si está presente
    $representado_por = isset($_POST['representado_por']) ? $_POST['representado_por'] : null;

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
            // Inserción de datos en la tabla tbl_registro_votos
            $usuario_id = $_SESSION['usuario']['id_usuario']; // Obtener el ID de usuario de la sesión
            $insert_query = "INSERT INTO tbl_registro_votos (id_empresa, id_usuario, fecha_registro, representado_por) VALUES ('$id', '$usuario_id', NOW(), '$representado_por')";
            if ($conn->query($insert_query)) {
                echo json_encode(array("status" => "success", "message" => 'El voto para la empresa con ID ' . $id . ' se ha registrado correctamente.'));
            } else {
                echo json_encode(array("status" => "error", "message" => "Hubo un error al registrar el voto para la empresa con ID $id: " . $conn->error));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Hubo un error al registrar el voto para la empresa con ID $id: " . $conn->error));
        }
    }
} else {
    echo $selectOptions; // Mostrar la lista de opciones si no se envió el formulario de registro de voto
}


// Cerrar la conexión a la base de datos
$conn->close();
?>
