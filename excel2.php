<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="votos.xls"');
echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
echo '<!--[if gte mso 9]><xml>';
echo '<x:ExcelWorkbook>';
echo '<x:ExcelWorksheets>';
echo '<x:ExcelWorksheet>';
echo '<x:Name>Sheet1</x:Name>';
echo '<x:WorksheetOptions>';
echo '<x:DisplayGridlines/>';
echo '</x:WorksheetOptions>';
echo '</x:ExcelWorksheet>';
echo '</x:ExcelWorksheets>';
echo '</x:ExcelWorkbook>';
echo '</xml><![endif]-->';
include("./config/conexion.php");

// Consulta para los votos
$sql_votos = "
SELECT 'Representante' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
UNION ALL
SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
UNION ALL
SELECT 'Votos' AS Tipo, COUNT(*) AS Total FROM votos WHERE voto = 1
";
$result_votos = $conn->query($sql_votos);

echo '<style>';
echo 'table { border-collapse: collapse; width: 30%; }';
echo 'thead { background-color: #ccc; }';
echo 'th, td { border: 1px solid #000; padding: 8px; }';
echo 'th:first-child, td:first-child { width: 10%; }'; // Ajusta el ancho de la primera columna al 50%
echo '</style>';
echo '<table>';
echo '<thead><tr><th>Tipo</th><th>Total</th></tr></thead>';
echo '<tbody>';
while ($row = $result_votos->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['Tipo'] . '</td>';
    echo '<td>' . $row['Total'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
exit;
?>
