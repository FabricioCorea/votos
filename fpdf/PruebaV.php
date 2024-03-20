<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
     
      $this->Image('logo.png', 20, 15, 40); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(85); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      //$this->Cell(110, 15, utf8_decode(''), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      //$this->Cell(96, 10, utf8_decode("Ubicación : "), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
     // $this->Cell(59, 10, utf8_decode("Teléfono : "), 0, 0, '', 0);
      $this->Ln(5);

      /* COREEO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
     // $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      //$this->Cell(85, 10, utf8_decode("Sucursal : "), 0, 0, '', 0);
      $this->Ln(10);

      /* TITULO DE LA TABLA */
      //color
      $this->Ln(3); // Salto de línea
      $this->Ln(3); // Salto de línea
      $this->Ln(3); // Salto de línea
      $this->Ln(3); // Salto de línea
      $this->Ln(3); // Salto de línea
      $this->Ln(3); // Salto de línea
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(32, 46, 66);
      $this->Cell(50); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE VOTACIÓN"), 0, 1, 'C', 0);
      $this->Ln(7);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      /*
      $this->SetFillColor(	233, 158, 0 ); //colorFondo amarillo
      $this->SetTextColor(0,0,0); //colorTexto negro
      $this->SetDrawColor(121, 120, 111 ); //colorBorde gris
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('NÚMERO'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('TIPO'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('PRECIO'), 1, 0, 'C', 1);
      $this->Cell(70, 10, utf8_decode('CARACTERÍSTICAS'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('ESTADO'), 1, 1, 'C', 1);
      */
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}
// Establecer la conexión con la base de datos
include("../config/conexion.php");

$sql = "
SELECT 'Representante' AS Tipo, COUNT(*) AS Total FROM votos WHERE presente = 0
UNION ALL
SELECT 'Representado' AS Tipo, COUNT(*) AS Total FROM votos WHERE representado = 0
UNION ALL
SELECT 'Votos' AS Tipo, COUNT(*) AS Total FROM votos WHERE voto = 1
";

$result = $conn->query($sql);

// Crear instancia de PDF
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->AliasNbPages();


// Definir el formato de la tabla en el PDF
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(233, 158, 0);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0);

// Calcular posición para centrar la tabla
$anchoTabla = 130; // Ancho total de la tabla
$margenIzquierdo = ($pdf->GetPageWidth() - $anchoTabla) / 2;

// Centrar la tabla en la página
$pdf->SetX($margenIzquierdo);

// Encabezados de la tabla
$pdf->Cell(65, 10, 'Tipo', 1, 0, 'C', 1);
$pdf->Cell(65, 10, 'Total', 1, 1, 'C', 1);

// Llenar el PDF con los datos recuperados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Contenido de la tabla
        $pdf->SetX($margenIzquierdo); // Asegurar que la primera celda se inicie desde la posición central
        $pdf->Cell(65, 10, $row["Tipo"], 1, 0, 'C');
        $pdf->Cell(65, 10, $row["Total"], 1, 1, 'C');
    }
} else {
    $pdf->Cell(130, 10, 'No hay resultados', 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('Votos.pdf', 'D');
echo '<a href="Votos.pdf" target="_blank">Descargar PDF</a>';

// Cerrar la conexión
$conn->close();
?>


<!--

/*
//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(121, 120, 111 ); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
   /*
$i = $i + 1;

/* TABLA */
/*
$pdf->Cell(18, 10, utf8_decode("N°"), 1, 0, 'C', 0);
$pdf->Cell(20, 10, utf8_decode("numero"), 1, 0, 'C', 0);
$pdf->Cell(30, 10, utf8_decode("nombre"), 1, 0, 'C', 0);
$pdf->Cell(25, 10, utf8_decode("precio"), 1, 0, 'C', 0);
$pdf->Cell(70, 10, utf8_decode("info"), 1, 0, 'C', 0);
$pdf->Cell(25, 10, utf8_decode("total"), 1, 1, 'C', 0);
*/

$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
-->
