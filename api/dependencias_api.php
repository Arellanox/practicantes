<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

#api
$api = $_POST['api'];
#buscar

$id = $_POST['id'];
$id_cliente = $_POST['id_cliente'];
#insertar
$id_dependencia = $_POST['id_dependencia'];
$cliente_id = $_POST['cliente_id'];
$segmento_id = $_POST['segmento_id'];

$parametros = array(
    $id_dependencia,
    $cliente_id,
    $segmento_id
);
$response="";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_dependencias_segmentos_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_dependencias_segmentos_b", [$id,$id_cliente]);
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_dependencias_segmentos_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_dependencias_segmentos_e", [$id]);
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
