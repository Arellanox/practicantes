<?php
include "./dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$pdf = new Dompdf();

$html = file_get_contents("./reporte_masometria.php");

// Definimos el tamaño y orientación del papel que queremos.
//$options = $pdf->getOptions();
// $options->set(array('isRemoteEnabled' => true));
// $pdf->setOptions ($options);
$pdf->loadHtml($html);

$pdf->setPaper("letter", "portrait");

// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('FicheroEjemplo.pdf');
