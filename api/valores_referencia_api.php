<?php
include_once '../clases/master_class.php';

$master = new Master();
$api = $_POST['api'];

//Datos de insertar
$servicio_id = $_POST['servicio_id'];
$sexo = $_POST['select-genero-referencia'];
$edad_minima = $_POST['edad_minima'];
$edad_maxima = $_POST['edad_maxima'];
$valor_minimo = $_POST['valor_minimo'];
$valor_maximo = $_POST['valor_maximo'];
$operadores_logicos_id = $_POST['select-operador-referencia'];
$valor_referencia = $_POST['valor_referencia'];

$insert_datos = $master->setToNull(array(
    $servicio_id,
    $sexo,
    $edad_minima,
    $edad_maxima,
    $valor_minimo,
    $valor_maximo,
    $operadores_logicos_id,
    $valor_referencia
));

switch ($api) {
    case 1:
        $response = $master->insertByProcedure('sp_valores_referencia_g', $insert_datos);
        break;

    default:
        $response = "API no definida";
        break;
}

echo $master->returnApi($response);
