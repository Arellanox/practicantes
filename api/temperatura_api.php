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
$usuario = $_SESSION['ID_USUARIO'];
$lectura = $_POST['lectura'];
$observaciones = $_POST['observaciones'];

$parametros =  array(
    "equipo" => $equipo,
    "termometro" => $termometro,
    "usuario" => $usuario,
    "lectura" => $lectura,
    "observaciones" => $observaciones
);

switch ($api) {

    case 1:
        # buscar equipos
        $response = $master->insertByProcedure("", $parametros);
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
