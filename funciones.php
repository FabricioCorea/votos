<?php
function conectar($servidor, $user, $pass, $name)
{


$con = @mysql_connect($servidor, $user, $pass) or die ("No se ha podido conectar al SERVIDOR de Base de datos");
@mysql_select_db($con, $name)  or die ( "No se ha podido conectar a la BASE de DATOS");

} 


?>