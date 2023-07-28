<?php 
include_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (! $tokenValido){
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$api = $_POST['api'];


switch ($api) {
    case 1:
        # buscar catalogo de uso de cfdi
        $response = $master->getByProcedure('sp_cfdi_b',[$id]);
        break;
    
    default:
        # code...
        break;
}
echo $master->returnApi($response);
?>