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

$fecha = $_POST['fecha'];



switch($api){
    case 1:
        # lista de estudios para la vista externa de ujat.
        $response = $master->getByProcedure("sp_lista_de_trabajo_ujat", [$fecha]);
        break;
    default:
        $response = "API no definida.";
        break;
}

echo $master->returnApi($response);
?>