<?php

include_once "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

#insertar nota consulta
$turno_id = $_POST['turno_id'];
$notas_consulta = $_POST['notas_consulta'];
$diagnostico = $_POST['diagnostico'];
$diagnostico2 = $_POST['diagnostico2'];
$plan_tratamiento = $_POST['plan_tratamiento'];
$activo = isset($_POST['ACTIVO']) ? null : 1;


$parametros = $master->setToNull(array(
    $turno_id,
    $notas_consulta,
    $diagnostico,
    $diagnostico2,
    $plan_tratamiento
));




switch($api) {
    #insertar datos en la tabla consultorio2_consulta
    case 1:
        $response = $master->insertByProcedure("sp_consultorio2_consulta_g", $parametros);
        break;

    // case 2:
    //     $response = $master->getByProcedure("sp_consultorio2_consulta_g", $turno_id);
    //     break;    

    default:
    $response = "API no definida";
        break;
}

echo $master->returnApi($response);
