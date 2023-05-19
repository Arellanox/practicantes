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
$total_cargos = $_POST['total_cargos'];
$subtotal = $_POST['subtotal'];
$iva = $_POST['iva'];
$total = $_POST['total'];
$pago =  $_POST['pago'];
$referencia = $_POST['referencia'];
$requiere_factura = $_POST['requiere_factura'];
$razon_social = $_POST['razon_social'];
$domicilio = $_POST['domicilio'];
$regimen_fiscal = $_POST['regimen_fiscal'];
$rfc = $_POST['rfc'];
$uso = $_POST['uso'];
$metodo_pago = $_POST['metodo_pago'];

$params = $master->setToNull(array(
    $id_ticket,
    $turno_id,
    $descuento_porcentaje,
    $descuento,
    $total_cargos,
    $subtotal,
    $iva,
    $total,
    $pago,
    $referencia,
    $requiere_factura,
    $razon_social,
    $domicilio,
    $regimen_fiscal,
    $rfc,
    $uso,
    $metodo_pago

));
# datos de factura

// print_r($params);
// exit;




switch ($api) {
    case 1:
        # guardar tickets
        $response = $master->insertByProcedure("sp_tickets_g", $params);
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
