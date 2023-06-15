<?php

include_once "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

$id_solicitud = $_POST['id_solicitud'];
$turno_id = $_POST['turno_id'];
$fecha_creacion = $_POST['fecha_creacion'];
$creado_por_id = $_POST['creado_por_id'];
$ruta_solicitud = $_POST['ruta_solicitud'];
$folio = $_POST['folio'];

//tabla foranea 
$servicio_id = $_POST['servicio_id'];

$activo = isset($_POST['ACTIVO']) ? null : 1;

$parametros = $master->setToNull(array(
    $id_solicitud,
    $turno_id,
    $creado_por_id,
    $ruta_solicitud,
    $servicio_id
));

switch($api){
    //insertar datos
    case 1:
        $response = $master->insertByProcedure('sp_consultorio_2_solicitudes_g', $parametros);
        break;
    
    //buscar datos    
    case 2: 
        $response = $master->getByProcedure('sp_consultorio_2_solicitudes_b', [$turno_id]);
        break;
    
    //Desactivar datos    
    case 4:
        $response = $master->deleteByProcedure('sp_consultorio_2_solicitudes_e', [$servicio_id, $turno_id]);
        break;    

     default:
        $response = "API no definida";
        break;   
}

echo $master->returnApi($response);