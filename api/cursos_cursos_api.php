<?php

include_once "../clases/master_class.php";
// require_once "../clases/token_auth.php";
include_once "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

$master = new Master();
$api = $_POST['api'];

$id_curso_detalle = $_POST['id_curso_detalle'];
$curso_id = $_POST['curso_id'];
$ciudad = $_POST['ciudad'];
$estado = $_POST['estado'];
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$modo = $_POST['modo'];
// $registrado_por = $_SESSION['id'];
$registrado_por = 10;

$response = [];
switch ($api) {
    case 1:
        #Guardar
        $response = $master->insertByProcedure('sp_cursos_cursos_detalle_g', [null, $curso_id, $ciudad, $estado, $fecha_inicial, $fecha_final, $modo, $registrado_por]);
        print_r($response);
        break;
    case 2:
        # Buscar
        $response = $master->getByProcedure('sp_cursos_cursos_detalle_b', [$id_curso_detalle]);
        break;
    case 3:
        # Actualizar
        $response = $master->updateByProcedure('sp_cursos_cursos_detalle_g', [$id_curso_detalle, $curso_id, $ciudad, $estado, $fecha_inicial, $fecha_final, $modo, $registrado_por]);
        break;
    case 4:
        # Desactivar
        $response = $master->deleteByProcedure('sp_cursos_cursos_detalle_e', [$id_curso_detalle]);
        break;
    default:
        # code...
        break;
}

echo $master->returnApi($response);
