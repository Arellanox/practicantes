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

# variables para la validaccion del pdf
$pdf_nube = $_POST['pdf_original'];
$pdf_a_comparar = $_FILES['pdf']['tmp_name'];

switch ($api) {

    case 1:

        $result = $master->getByProcedure('sp_recuperar_qr', [$clave, $area]);

        // print_r($result);
        // exit;


        if (!isset($result[0]['ERROR'])) {
            $response = [];
            foreach ($result as $r) {
                if (isset($r['info'])) {
                    $r['info'] = $master->decodeJsonRecursively([$r['info']]);
                }
                $response[] = $r;
            }
        } else {
            $response = $result[0]['ERROR'];
        }



        break;
    case 2:
        # validar que el pdf no haya sido modificado.
        $response = comparePDFContents($pdf_nube,$pdf_a_comparar);
        break;
    default:
        $response = "API no definida.";
}


echo $master->returnApi($response);


function comparePDFContents($file1, $file2) {
    // Leer el contenido de los archivos PDF
    $content1 = file_get_contents($file1);
    $content2 = file_get_contents($file2);

    if(!empty($file1) && !empty($file2)){
        // Comparar los contenidos de los archivos
        if ($content1 === $content2) {
            return "Los archivos tienen el mismo contenido.";
        } else {
            return "Los archivos tienen contenido distinto.";
        }
    } else {
        return "Error: Debes enviar 2 archivos.";
    }
   
}
