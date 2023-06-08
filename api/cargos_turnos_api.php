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
$turno_id = $_POST['turno_id'];
$num_factura = $_POST['num_factura'];


#variables para el reporte de la ujat
$ujat_inicial = $_POST['fecha_inicial'];
$ujat_final = $_POST['fecha_final'];
$id_cliente = isset($_POST['full_clientes']) ? 0 : $_POST['id_cliente'];

switch ($api) {
    case 1:
        $response = $master->getByProcedure('sp_cargos_turnos_b', [$turno_id]);
        $total_cargos = 0;

        foreach ($response as $e) {
            $total_cargos = $total_cargos + $e['PRECIO'];
        }

        // $areas = array();
        // foreach($response[1] as $current){
        //     $filtro = $current['ID_AREA'];
        //     $a = array_filter($response[0], function($obj) use($filtro){
        //         return $obj['ID_AREA'] == $filtro;
        //     });
        //     $areas[$current['ID_AREA']] = $a;
        //         }

        $response['estudios'] = $response;
        $response['TOTAL_CARGO'] = $total_cargos;

        break;
    case 2:
        # facturar un paciente particular
        $response = $master->insertByProcedure("sp_facturados_g", [$turno_id, $num_factura, $_SESSION['id']]);
        break;
    case 3:
        # reporte de ujat
        $params = $master->setToNull([
            $ujat_inicial,
            $ujat_final,
            $id_cliente
        ]);
        $response = $master->getByProcedure("sp_reporte_ujat", $params);
        break;
    case 4:
        # Crear un grupo de facturas

        break;
    default:
        $response = "Apino definida";
}

# regresamos el resultado el formato json
echo $master->returnApi($response);
