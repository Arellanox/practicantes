<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";


$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}


$api = $_POST['api'];
$master = new Master();

$servicio_id = $_POST['servicio_id'];



switch ($api) {
    case 1:
        $response = $master->getByProcedure("sp_precio_particulares_por_area", [$servicio_id]);
        break;
    default:
        $response = "API no definida.";
        break;
}

echo $master->returnApi($response);
