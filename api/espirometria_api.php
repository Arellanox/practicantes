<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();

#OBTENEMOS LA API POR MEDIO DEL POST
$api = $_POST['api'];


#EJECUTAMOS LA API 
switch ($api) {

        #GUARDAMOS LOS DATOS
    case 1:

        print_r($_POST['respuestas']);

        break;

    default:
        $response = "Api no definida";
}
