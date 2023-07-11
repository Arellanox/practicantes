<?php
include_once "../clases/master_class.php";

$master = new Master();

$datos = json_decode(file_get_contents('php://input'), true);

$api = $datos['api'];

#insertar datos
$msj = $datos['msj'];
//Nombre y numero del contacto
//Hora creacion del ticket


$fh = fopen("log.txt", 'a');
fwrite($fh, json_encode($datos));
fclose($fh);

$parametros = $master->setToNull(array(
    $msj
));

echo json_encode(['result' => '99999']);

// switch ($api) {
//     case 1:
//         $response = $master->insertByProcedure("sp_asistencia_ti_boot_g", $parametros);
//         break;

//     default:
//         break;
// }

// echo $master->returnApi($response);
