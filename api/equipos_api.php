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

$id_tipos_equipos = $_POST['id_tipos_equipos'];

$id_equipo = $_POST['id_equipo'];

switch ($api) {

    case 1:
        # buscar equipos
        $response = $master->getByProcedure("sp_laboratorio_equipos_b", [$id_equipo,  $id_tipos_equipos]);
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
