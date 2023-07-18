<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";
include "../clases/correo_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) { //Preregistro necesita recuperar antecedentes
    // $tokenVerification->logout();
    // exit;
}

$master = new Master();
$api = $_POST['api'];
$host = $_SERVER['SERVER_NAME'] =="localhost" ? "http://localhost/practicantes/" :  "https://bimo-lab.com/nuevo_checkup/";
$turno_id = $_POST['turno_id'];

print_r($_POST);
switch($api){
    case 1:
        # Guardar el pdf del certificado medico del paciente
        $dir = '../reportes/modulo/certificados_medicos/';
        $certificado = $master->guardarFiles($_FILES,'certificado',$dir,"CERTIFICADO_MEDICO_$turno_id");

        $ruta_certificado = str_replace("../",$host,$certificado[0]['url']);
        $response = $master->insertByProcedure("sp_certificados_medicos_tmp_g", [$turno_id, $ruta_certificado]);
        break;
}


echo $master->returnApi($response);



?>