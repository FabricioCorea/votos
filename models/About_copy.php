<?php
class About_Copy{
    private $conexion;
    function __construct()
    {
        requiere_once('../config/conexionPDO.php');
        $this->conexion = new conexion();
        $this->conexion = conectar();

    }
function TraerDatosGrafico(){
    $sql = " SELECT 'Presente' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
    UNION ALL
    SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
    UNION ALL
    SELECT 'Voto' AS Tipo, COUNT(*) AS Total FROM votos WHERE voto = 1
";
    $arreglo = array();
    if ($consulta = $this->conexion->conexion->query($sql)){
        while($consulta_VU = mysqli_fetch_array($consulta )){      
                $arreglo[] = $consulta_VU;
        }
        return $arreglo;
        $this->conexion->cerrar();

   }

    }

}


?>
