<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include_once "../clases/Pdf.php";
include_once "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();


$api = $_POST['api'];
$clave = $_POST['clave'];
$area = $_POST['area'];

switch ($api) {
    
    case 1:

        $result = $master->getByProcedure('sp_recuperar_qr', [$clave, $area]);

        // print_r($result);
        // exit;
        
        $response = [];
        foreach($result as $r){
            if(isset($r['info'])){
                $r['info']= $master->decodeJsonRecursively([$r['info']]);
            }
            $response[] = $r; 
        }

        break;
}






echo $master->returnApi($response);




?>