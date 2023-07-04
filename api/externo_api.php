<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";


$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}


$api = $_POST['api'];
$master = new Master();

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];



switch ($api) {
    case 1:
        # lista de estudios para la vista externa de ujat.
        $resultset = $master->getByProcedure("sp_lista_de_trabajo_ujat", [$fecha_inicial]);

        foreach($resultset as $set){
            $set['ESTUDIOS'] = $master->decodeJson([$set['ESTUDIOS']]);
            $response[] = $set;
        }

        break;
    default:
        $response = "API no definida.";
        break;
}

echo $master->returnApi($response);
