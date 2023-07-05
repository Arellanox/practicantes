<?php

session_start();
require_once "../clases/token_auth.php";
include_once '../clases/master_class.php';
include_once "../clases/Pdf.php";

$master = new Master();
// $tokenVerification = new TokenVerificacion();
// $tokenValido = $tokenVerification->verificar();
// if (!$tokenValido) {
//     // $tokenVerification->logout();
//     // exit;
// }
#Visualizar los reportes de ultrasonido y rayos X aqui
//Recibir las variables codificadas

// var myStr = "I am the string to encode";
// var token = encodeURIComponent(window.btoa(myStr));


$api = mb_convert_encoding(base64_decode(urldecode($_GET['api'])), 'UTF-8');
$turno_id = mb_convert_encoding(base64_decode(urldecode($_GET['turno'])), 'UTF-8');
$area_id = mb_convert_encoding(base64_decode(urldecode($_GET['area'])), 'UTF-8');
$usuario_id = $_SESSION['id'];


// mb_convert_encoding($rePa['paterno'],'UTF-8'));
// Imagenologia --> 8 para rayos y 11 para ultrasonido


$preview = 1; // <- debe estar activo, y la firma de quien interpreta no debe aparecer


switch ($api) {
    case 'imagenologia':
        # previsualizar el reporte [el reporte que previsualizan debe ir sin pie de pagina]
        $r = $master->reportador($master, $turno_id, $area_id, 'ultrasonido', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'oftalmo':
        $r = $master->reportador($master, $turno_id, 3, 'oftalmologia', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'laboratorio':
        $r = $master->reportador($master, $turno_id, 6, 'resultados', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'biomolecular':
        $r = $master->reportador($master, $turno_id, 12, 'biomolecular', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'etiquetas':
        $r = $master->reportador($master, $turno_id, 0, "etiquetas", "mostrar", $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'consultorio':
        $r = $master->reportador($master, $turno_id, 1, 'consultorio', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'consultorio2':
        $r = $master->reportador($master,$turno_id,$area_id,'consultorio2','mostrar',$preview,0,0,$id_cliente,$id_cotizacion);
        break;   
    case 'electro':
        $r = $master->reportador($master, $turno_id, $area_id, 'electro', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'soma':
        $r = $master->reportador($master, $turno_id, $area_id, 'reporte_masometria', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'cotizacion':
        $r = $master->reportador($master, $turno_id, 15, 'cotizaciones', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'ticket':
        $r = $master->reportador($master, $turno_id, $area_id, 'ticket', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'fast_checkup':
        $r = $master->reportador($master, $turno_id, 17, 'fast_checkup', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'corte':
        $r = $master->reportador($master, $turno_id, $area_id, 'corte', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'espiro':
        $r = $master->reportador($master, $turno_id, 5, 'espirometria', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
        break;
    case 'receta':
            $r = $master->reportador($master, $turno_id, $area_id, 'receta', 'mostrar', $preview, 0, 0, $id_cliente, $id_cotizacion);
            break;
    case 'solicitud_estudios':
            $r = $master->reportador($master,$turno_id,$area_id,'solicitud_estudios','mostrar',$preview,0, 0, $id_cliente,$id_cotizacion);
                break;                 
    default:
        echo '<script language="javascript">alert("¡URL invalida!"); window.close()</script>';
        break;
}
