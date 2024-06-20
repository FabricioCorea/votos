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
echo '</x:WorksheetOsptions>';
echo '</x:ExcelWorksheet>';
echo '</x:ExcelWorksheets>';
echo '</x:ExcelWorkbook>';
echo '</xml><![endif]-->';
include("../config/conexion.php");

// Consulta para los votos
$sql_votos = "
SELECT 
    v.id, 
    v.empresa, 
    v.representante, 
    CASE 
        WHEN v.presente = 0 THEN 'REPRESENTANTE' 
        WHEN v.representado = 0 THEN 'REPRESENTADO' 
        ELSE 'NO DEFINIDO' 
    END AS tipo, 
    r.representado_por, 
    u.usuario AS usuario_registrador, 
    r.fecha_registro 
FROM 
    votos v 
INNER JOIN 
    tbl_registro_votos r ON v.id = r.id_empresa 
INNER JOIN 
    tbl_usuarios u ON u.id_usuario = r.id_usuario 
WHERE 
    v.presente = 0 OR v.representado = 0 OR v.voto = 1;
";

$result_votos = $conn->query($sql_votos);

echo '<style>';
echo 'table { border-collapse: collapse; width: 30%; }';
echo 'thead { background-color: #ccc; }';
echo 'th, td { border: 1px solid #000; padding: 8px; }';
echo 'th:first-child, td:first-child { width: 10%; }'; // Ajusta el ancho de la primera columna al 50%
echo '</style>';
echo '<table>';
echo '<thead><tr><th>Id</th><th>Empresa</th><th>Representante Legal</th><th>Tipo de Voto</th><th>Representado por</th><th>Registrado por</th><th>Fecha y Hora de Registro</th></tr></thead>';
echo '<tbody>';
while ($row = $result_votos->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['empresa'] . '</td>';
    echo '<td>' . $row['representante'] . '</td>';
    echo '<td>' . $row['tipo'] . '</td>';
    echo '<td>' . $row['representado_por'] . '</td>';
    echo '<td>' . $row['usuario_registrador'] . '</td>';
    echo '<td>' . $row['fecha_registro'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
exit;
?>
