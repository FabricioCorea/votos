<?php

$servidor = "localhost";
$user= "root";
$pass= "";
$database = "voto";




$conn = mysqli_connect($servidor, $user, $pass, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";



$id = strip_tags($_POST["id"]);
//$empresa = strip_tags($_POST["empresa"]);
//$representante = strip_tags($_POST["representante"]);
$presente = strip_tags($_POST["subject"]);
//$voto = strip_tags($_POST["voto"]);

$query = mysqli_query($conn, "SELECT *  FROM votos WHERE id = $id and voto > 0");
$row_cnt = mysqli_num_rows($query);

$query3= mysqli_query($conn,"SELECT COUNT(*) FROM `votos` WHERE presente like 'REPRESENTANTE'");
$row_cnt3 = mysqli_num_rows($query3);



if ($row_cnt > 0) {
	echo 'Voto de empresa con código '.$id.' registrado anteriormente.';
	echo "<br>";
	echo '<a href="index.php">REGRESAR</a>';
}

else{
	try {
			/*CÒDIGO ANTERIOR
					$query2 = mysqli_query($conn, "SELECT *  FROM votos WHERE id = $id");
					$row_cnt2 = mysqli_num_rows($query2);

					$meter = "update votos set voto =1,  presente = '$presente' where id = '$id'";

		if (mysqli_query($conn, $meter) and $row_cnt2 > 0) {
			echo "Registrado Con Exito  ".$row_cnt3;
			
		} else {
			echo "Hubo un error en al registrar el código de empresa $id." . mysqli_error($conn);
		}*/
		
		//CÒDIGO MODIFICADO
		$query2 = mysqli_query($conn, "SELECT *  FROM votos WHERE id = $id");
        $row_cnt2 = mysqli_num_rows($query2);

        $campoActualizar = ""; 	//VARIABLE QUE ALMACENA EL CAMPO SEGÙN LA OPCIÒN CAPTURADA
        if ($presente === "REPRESENTANTE") {
            $campoActualizar = "presente";
        } elseif ($presente === "REPRESENTADO") {
            $campoActualizar = "representado";
        }

        $meter = "UPDATE votos SET voto = 1, $campoActualizar = '$presente' WHERE id = '$id'";

        if (mysqli_query($conn, $meter) && $row_cnt2 > 0) {
			echo 'Voto de empresa con código '.$id.' registrado con éxito.';
        } else {
            echo "Hubo un error al registrar el código de empresa $id: " . mysqli_error($conn);
        }
	}
		catch	(Exception $e)
		{
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}

		echo "<br>";
		echo '<a href="index.php">REGRESAR</a>'; //en vez de localhost debo colocar mi ip fija

		

	}


mysqli_close($conn);

?>