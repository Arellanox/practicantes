<?php
include "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();

$api = $_POST['api'];
$equipo =  $_POST['Enfriador'];
$termometro = $_POST['Termometro'];
$usuario = $_SESSION['id'];
$lectura = $_POST['lectura'];
$observaciones = $_POST['observaciones'];

$parametros =  array(
    $equipo,
    $termometro,
    $usuario,
    $lectura,
    $observaciones
);

$anho = $_POST['anho'];
$folio = $_POST['folio'];

switch ($api) {

    case 1:
        # buscar equipos
        $response = $master->insertByProcedure("sp_temperatura_g", $parametros);
        break;
    case 2:
        $response = $master->getByProcedure("sp_temperaturas_resultados_b", [$anho]);
        break;
    case 3:
        $response = $master->getByProcedure("sp_temperatura_detalle_b", [$folio]);
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
