<?php 
include "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

$id_solicitud = $_POST['id_solicitud'];
$turno_id = $_POST['turno_id'];
$archivo = $_POST['archivo'];
$ruta = $_POST['ruta'];
$tipo = $tipo['tipo'];

$solicitud_object = array(
    $id_solicitud,
    $turno_id,
    $archivo,
    $ruta,
    $tipo
);

switch ($api) {
    case 1:
        # insertar las solicitudes
        $response = $master->insertByProcedure('sp_solicitudes_g',$solicitud_object);
        break;

    case 2:
        # buscar 
        $response = $master->getByProcedure('sp_solicitudes_b',[$id_solicitud,$turno_id]);
        break;

    case 3:
        # actualizar
        $response = $master->updateByProcedure('sp_solicitudes_g',$solicitud_object);
        break;
    case 4:
        # eliminar las solicitudes
        $response = $master->deleteByProcedure('sp_solicitudes_e',[$id_solicitud]);
        break;
    
    default:
        # code...
        echo "Api no reconocida.";
        break;
}

echo $master->returnApi($response);
?>