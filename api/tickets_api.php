<?php
include "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();

$api = $_POST['api'];

# tabla tickets
$id_ticket = $_POST['id_ticket'];
$turno_id = $_POST['turno_id'];
$descuento_porcentaje = $_POST['descuento_porcentaje'];
$descuento = $_POST['descuento'];
$subtotal = $_POST['subtotal'];
$iva = $_POST['iva'];
$total = $_POST['total'];
$pago =  $_POST['pago'];
$referencia = $_POST['referencia'];
$requiere_factura = $_POST['requiere_factura'];
$dato = $_POST['dato'];

$params = $master->setToNull(array(
    $id_ticket,
    $turno_id,
    $descuento_porcentaje,
    $descuento,
    $subtotal,
    $iva,
    $total,
    $pago,
    $referencia,
    $requiere_factura,
    $dato
));
# datos de factura




switch ($api) {
    case 1:
        # guardar tickets
        $response = $master->insertByProcedure("sp_tickets_g", $params);
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
