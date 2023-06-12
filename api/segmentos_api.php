<?php
require_once "../clases/master_class.php";
// require_once "../clases/token_auth.php";

// $tokenVerification = new TokenVerificacion();
// $tokenValido = $tokenVerification->verificar();
// if (!$tokenValido) {
//     $tokenVerification->logout();
//     exit;
// }

#api
$api = $_POST['api'];

#buscar
$id = $_POST['id'];
$id_cliente = $_POST['cliente_id'];

#insertar
$id_segmento = $_POST['id_segmento'];
$cliente_id = $_POST['cliente_id'];
$padre = $_POST['padre'];
$descripcion = $_POST['descripcion'];

$parametros = array(
    $id_segmento,
    $cliente_id,
    $padre,
    $descripcion
);
$response="";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_segmentos_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_segmentos_b", [$id_cliente,$id]);
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_segmentos_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_segmentos_e", [$id]);
        break;
        
    case 5:
        #segmentos padres e hijos por cliente
        $response = $master->deleteByProcedure("fillSelect_segmentos", [$id_cliente]);
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
