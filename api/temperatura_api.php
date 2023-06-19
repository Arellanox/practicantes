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
$turno = $_POST['turno'];

#Firma del usuario que registra una nueva temperatura

$firma = $_POST['firma'];

/* 

die();
$firma = str_replace('data:image/png;base64,', '', $firma);
$firma = str_replace(' ', '+', $firma);
$firma = base64_decode($firma); */




$parametros =  array(
    $equipo,
    $termometro,
    $usuario,
    $lectura,
    $observaciones,
    $id_registro_temperatura,
    $firma
);

$anho = $_POST['anho'];
$folio = $_POST['folio'];


#datos que manda el supervisor para liberar un dia
$fecha_inicial = $_POST['FechaInicio'];
$fecha_final = $_POST['FechaFinal'];
#datos que manda el supervisor para liberar un dia 2.0
$estatus = $_POST['estatus'];


$parametros_g = array(
    $fecha_inicial,
    $fecha_final,
    $observaciones,
    $usuario,
    $equipo,
    $turno
);

$parametros_a = array(
    $id_registro_temperatura,
    $estatus,
    $usuario
);





switch ($api) {

    case 1:
        # buscar equipos
        $response = $master->insertByProcedure("sp_temperatura_g", $parametros);
        break;
    case 2:
        $response = $master->getByProcedure("sp_temperaturas_resultados_b", [$equipo]);
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

    case 6:
        #Liberar un registro
        $response = $master->insertByProcedure("sp_temperatura_supervisor_a", $parametros_a);
        break;
    case 7:
        #Llenar tabla del formato PDF, pasar ID del FOLIO
        $response = $master->getByProcedure('sp_temperatura_formato_b', [$folio]);

        $result = array();
        $i = 1;
        foreach ($response as $key => $e) {
            $dia = $e['DIA'];
            $turno = $e['TURNO'];
            $valor = $e['valor'];
            $color = $e['MODIFICADO'] == 0 ?  "blue" : "mostaza";

            if (!isset($result[$dia])) {
                $result[$dia] = array();
            }

            if ($i = 3) {
                $i = 1;
            }

            $result[$dia][$i] = array("valor" => $valor, "color" => $color);
            $i++;
        };

        $response = $result;
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
