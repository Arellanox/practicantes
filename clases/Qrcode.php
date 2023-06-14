<?php
require_once '../php/codeqr/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

function generarQRURL($clave, $folio, $modulo, $url = 'resultados/validar-pdf/')
{

    $options = new QROptions([
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
    ]);

    $host =  /*isset($_SERVER['SERVER_NAME']) ? "http://localhost/nuevo_checkup/" :*/ "https://bimo-lab.com/nuevo_checkup/";

    $contenido = $host . $url . '?clave=' . $clave . '&id=' . $folio . '&modulo=' . $modulo;

    $qrcode = (new QRCode())->render($contenido);

    return array($contenido, $qrcode);
}
