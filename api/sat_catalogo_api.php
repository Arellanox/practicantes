<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}


$api = isset($_POST['api']) ?  $_POST['api'] : (isset($_GET['api']) ? $_GET['api'] : 0);

#buscar
$id = $_POST['id'];

#insertar
$sat_id_codigo = $_POST['sat_id_codigo'];
$sat_id_clase = $_POST['sat_id_clase'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];

$parametros = array(
    $sat_id_codigo,
    $sat_id_clase,
    $codigo,
    $descripcion
);


$response = "";

$master = new Master();
switch ($api) {
    case 1:
        #insert
        $response = $master->insertByProcedure('sp_catalogo_g', $parametros);
        break;
    case 2:
        #getall
        $response = $master->getByProcedure('sp_catalogo_b', array($id));
        break;
    case 3:
        #update
        $response = $master->updateByProcedure('sp_catalogo_g', $parametros);
        break;
    case 4:
        #eliminar
        $response = $master->deleteByProcedure('sp_catalogo_e', array($id));
        break;
    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
