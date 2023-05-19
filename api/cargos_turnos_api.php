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

switch($api){
    case 1:
        $response = $master->getByProcedure('sp_cargos_turnos_b_angel',[$turno_id]);
        $total_cargos = 0;

        foreach($response as $e){
            
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
    default:
    $response = "Apino definida";    
}

echo $master->returnApi($response);


?>