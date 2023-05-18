<?php 
include "../clases/master_class.php";

$master = new Master();
$api = $_POST['api'];

#buscar
$id_regimen = $_POST['id_regimen'];

switch($api){
    case 1:
        #buscar regimens del sat
        $response = $master->getByProcedure('sp_regimen_b',[$id_regimen]);
        break;
    default:
        echo "Api no reconocida.";
        break;
}

echo $master->returnApi($response);
?>