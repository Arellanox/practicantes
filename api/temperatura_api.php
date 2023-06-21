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


#comentario que mandara el supervisor a los registros
$comentario = $_POST['comentario'];

#ID de comentario para elimanr un comentario
$id_comentario = $_POST['id_comentario'];

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

$comentarios = array(
    $comentario,
    $usuario,
    $id_registro_temperatura
);

$comentarios_delete = array(
    $id_comentario,
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
            $intervalo_min = $e['INTERVALO_MIN'];
            $intervalo_max = $e['INTERVALO_MAX'];
            $color = $e['MODIFICADO'] == 0 ?  "blue" : "mostaza";
            $id_registro = $e['ID_REGISTRO_TEMPERATURA'];
            if (!isset($result[$dia])) {
                $result[$dia] = array();
            }

            // if ($i === 3) {
            //     $i = 1;
            // }

            if ($turno === "MATUTINO") {
                $i = 1;
            } else {
                $i = 2;
            }

            $result[$dia][$i] = array("valor" => $valor, "color" => $color, "id" => $id_registro);
            $i++;
        };

        $response = [];
        $response['EQUIPO']['INTERVALO_MIN'] = $intervalo_min;
        $response['EQUIPO']['INTERVALO_MAX'] = $intervalo_max;

        $response['DIAS'] = $result;
        break;
    case 8:
        #Agregar Comentarios Superivisor 
        $response = $master->insertByProcedure('sp_temperaturas_comentarios_g', $comentarios);
        break;
    case 9:
        #Buscar comentarios por el ID de registro de la temperatura
        $response = $master->getByProcedure("sp_temperaturas_comentarios_b", [$id_registro_temperatura]);
        break;
    case 10:
        $response = $master->insertByProcedure('sp_temperaturas_comentarios_e', $comentarios_delete);
        break;
    default:
        $response = "Api no definida.";
}

echo $master->returnApi($response);
