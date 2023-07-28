<?php
include_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$api = $_POST['api'];
$id_pieza = $_POST['id_pieza'];


switch ($api) {
    case 1:
        #recuperar piezas dentales
        $response = $master->getByProcedure("sp_consultorio_piezas_dentales_b",[$id_pieza]);
        break;

    case 2:
        # eliminar pieza dental
        $response = $master->deleteByProcedure("",[]);
        break;

    default:
}

echo $master->returnApi($response);
 ?>