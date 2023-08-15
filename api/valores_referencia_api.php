<?php
include_once '../clases/master_class.php';
include_once '../clases/token_auth.php';

$master = new Master();
$api = $_POST['api'];

//Datos de insertar
$servicio_id = $_POST['servicio_id'];
$sexo = $_POST['select-genero-referencia'];
$edad_minima = $_POST['edad_minima'];
$edad_maxima = $_POST['edad_maxima'];
$valor_minimo = $_POST['valor_minimo'];
$valor_maximo = $_POST['valor_maximo'];
$presentacion = $_POST['presentacion'];
$operadores_logicos_id = $_POST['select-operador-referencia'];
$valor_referencia = $_POST['valor_referencia'];
$checkedCambiarReferencia = $_POST['checkedCambiarReferencia'];
$valores_normalidad = $_POST['valores_normalidad'];

$checkedCambiarReferencia == 0 ? $operadores_logicos_id = null : $operadores_logicos_id = $operadores_logicos_id;

//Desativar datos
$id_valores_referencia = $_POST['id_valores_referencia'];

$insert_datos = $master->setToNull(array(
    $servicio_id,
    $sexo,
    $edad_minima,
    $edad_maxima,
    $valor_minimo,
    $valor_maximo,
    $presentacion,
    $operadores_logicos_id,
    $valor_referencia,
    $valores_normalidad,
    $id_valores_referencia
));

switch ($api) {
        //Insertar datos en la tabla referencia_valores
    case 1:
        $response = $master->insertByProcedure('sp_valores_referencia_g', $insert_datos);
        break;

        //Busca campos de operadores logicos
    case 2:
        $response = $master->getByProcedure('sp_operadores_logicos_b', []);
        break;

        //Buscar todos los campos para tabla
    case 3:
        $response = $master->getByProcedure('sp_valores_referencia_b', [$servicio_id]);
        break;

    case 4:
        $response = $master;
        break;

    default:
        $response = "API no definida";
        break;
}

echo $master->returnApi($response);
