<?php

require '../models/About_copy.php';

$AC = new About_Copy();
$consuta = $AC -> TraerDatosGrafico();
echo json_encode($consuta);

?>