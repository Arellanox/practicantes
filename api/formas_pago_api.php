<?php
include "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

// meter como el catalog de titutlos.

$master = new Master();

$api = $_POST['api'];
$activo = $_POST['activo'];

switch($api){

    case 2:
        # buscar metodos de pago
        $response = $master->getByProcedure("sp_formas_pago_b",[$activo]);
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);

?>