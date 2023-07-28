<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$api = $_POST['api'];

# datos de la cotizacion
$id_cotizacion = $_POST['id_cotizacion'];
$cliente_id = $_POST['cliente_id'];
$atencion = $_POST['atencion'];
$correo = $_POST['correo'];
$subtotal = $_POST['subtotal'];
$iva = $_POST['iva'];
$descuento = $_POST['descuento'];
$descuento_porcentaje = $_POST['descuento_porcentaje'];
$total = $_POST['total'];
# este es el arreglo de los servicios que contiene la cotizacion 
$detalle = $_POST['detalle'];
$observaciones = $_POST['observaciones'];

switch ($api) {
    case 1:
        # guardar cotizacion
        $response = $master->insertByProcedure("sp_cotizaciones_g", [$id_cotizacion, $cliente_id, $atencion, $correo, $subtotal, $iva, $descuento, $descuento_porcentaje, $observaciones, $total, $_SESSION['id'], json_encode($detalle)]);
        break;
    case 2:
        # buscar informacion de las cotizaciones
        $dataset = $master->getByNext("sp_cotizaciones_b", [$id_cotizacion, $cliente_id]);
        $response = array();

        foreach ($dataset[0] as $set) {
            $set['DETALLE'] = array_filter($dataset[1], function ($obj) use ($set) {
                return $set['ID_COTIZACION'] == $obj['COTIZACION_ID'];
            });

            $response[] = $set;
        }
        break;
    case 3:
        # eliminar cotizacion
        $response = $master->deleteByProcedure("sp_cotizaciones_e", [$id_cotizacion]);
        break;

    case 4:
        # solo cotizacinoes sin detalle.
        $response = $master->getByProcedure("sp_cotizaciones_gral", [$cliente_id]);
        break;
    default:
        $response = "Api no definida. Api " . $api;
        break;
}

echo $master->returnApi($response);
