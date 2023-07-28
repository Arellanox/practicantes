<?php
session_start();
require_once "../clases/token_auth.php";
include_once '../clases/master_class.php';
include_once "../clases/Pdf.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
   #$tokenVerification->logout();
   #exit;
}

$api = $_POST['api'];
$master = new Master();

# para las interpretaciones o reportes que se suban ya convertidos en pdf
$id_imagen = $_POST['id_imagen'];
$turno_id = $_POST['turno_id'];
$area_id = $_POST['area_id'];
$interpretacion = $_POST['interpretacion'];
$usuario = $_SESSION['id'];


# para el detalle de las imagenes.
# cuando suban los resultados en el formuliar que contienen los campos de hallazgos, interpretacion, etc
$id_rayo = $_POST['id_rayo'];
$servicio = $_POST['servicio_id'];
$hallazgo = $_POST['hallazgo'];
$inter_texto = $_POST['inter_texto'];
$comentario = $_POST['comentario'];

switch($api){
    case 1:
        # insertar
        # Subir el reporte pdf del pacs
        # definimos la ruta del reporte segun el area
        $area = $area_id == 8 ? "RX" : "ULTRASONIDO";

        #creamos el directorio donde se va a guardar la informacion del turno
        $ruta_saved = "reportes/modulo/$area/$turno_id/interpretacion/";
        $r = $master->createDir("../".$ruta_saved);

        if($r!=1){
            $response = "No se pudo crear el directorio de carpetas. Interpretacion.";
            break;
        }

        break;
    default:
        $response ="Api no definida.";
        break;
}
?>