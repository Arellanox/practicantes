<?php

include_once "../clases/master_class.php";

$master = new Master();

$api = $_POST['api'];

//datos a insertar
$turno_id = $_POST['turno_id'];
$exploracion_tipo_id = $_POST['exploracion_tipo_id'];
$exploracion = $_POST['exploracion'];

//desactivar exploracion
$id_exploracion_2_clinica = $_POST['id_exploracion_2_clinica'];

$parametros = $master->setToNull(array(
    $turno_id,
    $exploracion_tipo_id,
    $exploracion
));

switch($api){

    //Insertar datos en la tabla consultorio_exploracion_2_clinica
    case 1:
        $response = $master->insertByProcedure('sp_consultorio_exploracion_2_clinica_g', $parametros);
        break;

    case 2:
        $response = $master->getByProcedure('sp_consultorio_exploracion_2_clinica_b', [$turno_id]);
        break;    

    case 5:
        $response = $master->deleteByProcedure('sp_consultorio_exploracion_2_clinica_e', [$id_exploracion_2_clinica]);
        break;    
     default:
     $response = "API no definida";
        break;   
}

echo $master->returnApi($response);