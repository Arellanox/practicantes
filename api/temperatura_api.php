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
$lectura = isset($_POST['lectura']) ? $_POST['lectura'] : null;
$lectura = "-$lectura";
$observaciones = $_POST['observaciones'];
$id_registro_temperatura = $_POST['id_registro_temperatura'];

$parametros =  array(
    $equipo,
    $termometro,
    $usuario,
    $lectura,
    $observaciones,
    $id_registro_temperatura
);

$anho = $_POST['anho'];
$folio = $_POST['folio'];


#datos que manda el supervisor para liberar un dia


$dia = $_POST['diaLiberar'];
$hora = $_POST['horaLiberar'];


$parametros_g = array(
    $dia,
    $hora,
    $observaciones,
    $usuario
);


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
    case 4:
        #Actualizar temperatura
        break;
    case 5:
        #Supervisor Liberar un  dia
        $response = $master->insertByProcedure("sp_temperatura_supervisor_g", $parametros_g);

        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
