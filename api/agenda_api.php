<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();
$api = $_POST['api'];
$id_agenda = $_POST['id_agenda'];
$paciente = $_POST['id_paciente'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['numero'];
$fecha_agenda = $_POST['date'];
$area_id = $_POST['area_id'];
$registrado_por = $_SESSION['id'];
$observaciones = $_POST['observaciones'];
$detalle_servicios = $_POST['servicios'];
$hora_agenda = $_POST['hora_agenda']; # este es un id que viene de la tabla agenda horarios

#horarios
$hora_inicial = $_POST['hora_cita'];


$params = $master->setToNull([
    $paciente,
    $nombre,
    $apellidos,
    $telefono,
    $fecha_agenda,
    $area_id,
    $registrado_por,
    $observaciones,
    json_encode(explode(",", $detalle_servicios)),
    $hora_agenda
]);

switch ($api) {
    case 1:
        # agregar una agenda
        $response = $master->insertByProcedure("sp_agenda_g", $params);
        break;
    case 2:
        # buscar los horarios disponibles de un area.
        $response = $master->getByProcedure("sp_agenda_horarios_b2", [$area_id, $fecha_agenda]);
        break;
    case 3:
        #buscar agendas
        $response = $master->getByProcedure("sp_agenda_b", [$area_id, $fecha_agenda]);

        for ($i=0; $i < count($response); $i++) { 
            $response[$i]["DETALLE_AGENDA"] = $master->decodeJson([$response[$i]["DETALLE_AGENDA"]]);
        }
        break;
    case 4:
        # eliminar una agenda
        $response = $master->deleteByProcedure("sp_agenda_e", [ $id_agenda ]);
        break;
    case 5:
        # agregar una horario a un area
        $response = $master->insertByProcedure("sp_agenda_horarios_g", [ null, $hora_inicial, $area_id]);
        break;
    case 6:
        # eliminar horarios de un area
        $response = $master->deleteByProcedure("sp_agenda_horarios_e", [$hora_inicial, $area_id]);
        break;
    default:
        break;
}

echo $master->returnApi($response);
