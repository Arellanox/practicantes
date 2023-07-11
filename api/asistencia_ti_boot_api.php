<?php
include_once "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

#insertar datos
$msj = $_POST['msj'];

$parametros = $master->setToNull(array(
    $msj
));

switch($api){
    case 1:
        $response = $master->insertByProcedure("sp_asistencia_ti_boot_g", $parametros);
        break;

    default:
        break;   
}

echo $master->returnApi($response);