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
$api = $_POST['api'];

# datos de la cotizacion
$id_cotizacion = isset($_POST['id_cotizacion']) ? $_POST['id_cotizacion'] : null;
$cliente_id = $_POST['cliente_id'];
$atencion = $_POST['atencion'];
$correo = $_POST['correo'];
$subtotal = $_POST['subtotal'];
$iva = $_POST['iva'];
$descuento = $_POST['descuento'];
$descuento_porcentaje = $_POST['descuento_porcentaje'];
$total = $_POST['total'];
# este es el arreglo de los servicios que contiene la cotizacion 
$detalle = $_POST['detalle'];
$observaciones = $_POST['observaciones'];
$subtotal_sin_descuento = $_POST['subtotal_sin_descuento'];


switch ($api) {
    case 1:
        # guardar cotizacion

        $response = $master->insertByProcedure("sp_cotizaciones_g", [$id_cotizacion, $cliente_id, $atencion, $correo, $subtotal, $iva, $descuento, $descuento_porcentaje, $observaciones, $total, $_SESSION['id'], json_encode($detalle), $subtotal_sin_descuento]);

        #Obtemos el ID_COTIZACION para crear el poder crear el PDF
        $id_cotizacion_pdf = $master->getByProcedure('sp_cotizaciones_info_b',[$id_cotizacion]);
        $id_cotizacion_pdf = $id_cotizacion_pdf[0]['ID_COTIZACION'];
        
        //Guardamos el PDF de la cotizacion
        $url = $master->reportador($master, null, 13, 'cotizaciones', 'url', 0,0,0,$cliente_id, $id_cotizacion_pdf);
        
        $response1 = $master->updateByProcedure("sp_reportes_actualizar_ruta", ['cotizaciones', 'RUTA_REPORTE', $url, $id_cotizacion_pdf, 13]);


        break;
    case 2:
        # buscar informacion de las cotizaciones
        $dataset = $master->getByNext("sp_cotizaciones_b", [$id_cotizacion, $cliente_id]);
        $response = array();

        foreach ($dataset[0] as $set) {
            $set['DETALLE'] = array_filter($dataset[1], function ($obj) use ($set) {
                return $set['ID_COTIZACION'] == $obj['COTIZACION_ID'];
            });

            $response[] = $set;
        }
        break;
    case 3:
        # eliminar cotizacion
        $response = $master->deleteByProcedure("sp_cotizaciones_e", [$id_cotizacion]);
        break;

    case 4:
        # solo cotizacinoes sin detalle.
        $response = $master->getByProcedure("sp_cotizaciones_gral", [$cliente_id]);
        break;
    

    case 5:
        #Enviar el correo 

        $response = $master->getByProcedure("sp_cotizaciones_info_b", [$id_cotizacion]);
        $correo = $response[0]['CORREO'];
        $reporte = $response[0]['RUTA_REPORTE'];


        if (!empty($response[0])) {
            $mail = new Correo();
            if ($mail->sendEmail('cotizacion', '[bimo] Cotización', [$correo], null, [$reporte], 1)) {
                $master->setLog("Correo enviado.", "Reporte de Cotización enviado");
            }
        }

        break;

    default:
        $response = "Api no definida. Api " . $api;
        break;
}

echo $master->returnApi($response);
