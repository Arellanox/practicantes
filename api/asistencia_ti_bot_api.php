<?php
include_once "../clases/master_class.php";

$master = new Master();

$datos = json_decode(file_get_contents('php://input'), true);

$api = $datos['api'];

#insertar datos
$msj = $datos['msj'];
$nombre_usuario = $datos['nombre_usuario'];
$numero_usuario = $datos['numero_usuario'];

$fh = fopen("log.txt", 'a');
fwrite($fh, json_encode($datos));
fclose($fh);

$parametros = $master->setToNull(array(
    $msj,
    $nombre_usuario,
    $numero_usuario
));

// echo json_encode(['result' => '99999']);
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_asistencia_ti_bot_g", $parametros);
        break;

    default:
        $response = "API no definida";
        break;
}

echo $master->returnApi (["TICKET" => $response]);
