<?php


header('Content-Type: application/xls');
header('Content-Disposition: attachment;filename="votos.xlsx"');

include("./config/conexion.php");

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql = "
SELECT 'Representante' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
UNION ALL
SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
UNION ALL
SELECT 'Votos' AS Tipo, COUNT(*) AS Total FROM votos WHERE voto = 1
";

$result = $conn->query($sql);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Votos");

$hojaActiva->setCellValue('A1', 'Tipo');
$hojaActiva->setCellValue('A1', 'Total');

$fila = 2;

while($rows = $resultado->fetch_assoc()){

    $$hojaActiva->setCellValue('A'.$fila, $rows['Tipo']);
    $$hojaActiva->setCellValue('A'.$fila, $rows['Total']);
    $fila++;
}



?>