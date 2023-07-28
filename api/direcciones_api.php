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

#insertar
$id_direccion = $_POST['id_direccion'];
$cliente_id = $_POST['cliente_id'];
$tipo = $_POST['tipo']; # <-- Tipo de direccion (fiscal, envio de documentos...)
$calle = $_POST['calle'];
$num_exterior = $_POST['num_exterior'];
$num_interior = $_POST['num_interior'];
$cp = $_POST['cp'];
$colonia = $_POST['colonia'];
$ciudad = $_POST['ciudad'];
$municipio = $_POST['municipio'];
$estado = $_POST['estado'];
$pais = $_POST['pais'];

$parametros = array(
    $id_direccion,
    $cliente_id,
    $tipo,
    $calle,
    $num_exterior,
    $num_interior,
    $cp,
    $colonia,
    $ciudad,
    $municipio,
    $estado,
    $pais
);

$response = "";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_direcciones_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_direcciones_b", [$id, $cliente_id]);
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_direcciones_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->deleteByProcedure("sp_direcciones_e", [$id]);
        break;

    default:
        $response = "api no reconocida";
        break;
}
echo $master->returnApi($response);
