<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}

#api

$api = $_POST['api'];
#buscar

$contenido = $_POST['contenido'];
$paquete = $_POST['id_paquete'];
$cliente = $_POST['id_cliente'];

//$id_cliente = $_POST['id_cliente'];
#insertar

$id_paquete = $_POST['id'];
$cliente_id = $_POST['cliente_id'];
$concepto_id = $_POST['concepto_id'];
$descripcion = $_POST['descripcion'];
$tipo_paquete = $_POST['tipo_paquete'];
$costo = $_POST['costo'];
$utilidad = $_POST['utilidad'];
$precio_venta = $_POST['precio_venta'];
$iva = $_POST['iva'];

# para eliminar el detalle de un paquete
$eliminados = $_POST['contenido'];

$parametros = array(
    $id_paquete,
    $cliente_id,
    $concepto_id,
    $descripcion,
    $tipo_paquete,
    $costo,
    $utilidad,
    $precio_venta,
    $iva
);

$response = "";

$master = new Master();
switch ($api) {
    case 1:
        # insertar
        // print_r($parametros);
        $response = $master->insertByProcedure("sp_paquetes_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_paquetes_b", [$id_paquete, $cliente_id, $contenido]);
        break;

    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_paquetes_g", $parametros);
        break;
    case 4:
        # desactivar
        $response = $master->updateByProcedure("sp_paquetes_e", $parametros);
        break;

    case 5:
        # encontrar los paquetes que no han sido asigandos a algun cliente.
        $response = $master->getByProcedure('sp_paquetes_sin_clientes', array());

        break;
    case 6:



        #detalles de un paquete
        $detalle = $_POST['paquete_detalle'];
        //print_r($detalle);
        # obtiene el arreglo del final
        $info_paquete = array_slice($detalle, count($detalle) - 1, 1);
        #quita la informacion del paquete, solo deja los detalles
        $detalle_final = array_pop($detalle);
        #variables para verificar si se insertaron todos los detalles del paquete,
        $len_detalle = count($detalle);
        $oks = 0;
        //print_r($detalle);
        //print_r($info_paquete);

        $id_paquete =  $info_paquete[0]['id_paquete'];

        #desactivo todos los detalles actuales del paquete para poder dejar unicamente los cambios que estoy recibiendo
        $array_reset = array(null, $id_paquete, null, null, null, null, null, null, 1 /*reseatear contenido */);
        $desactivados = $master->deleteByProcedure('sp_detalle_paquete_g', $array_reset);

        if (is_numeric($desactivados)) {
            foreach ($detalle as $det) {
                $newDet = array(
                    null,
                    $id_paquete,
                    $det['id'],
                    $det['cantidad'],
                    $det['costo'],
                    $det['costototal'],
                    $det['precioventa'],
                    $det['subtotal'],
                    //descuento
                    0 #resetear contenido
                );
                $response =  $master->returnApi($master->insertByProcedure('sp_detalle_paquete_g', $newDet));
                $response = json_decode($response, true);
                if ($response['response']['code'] == 1) {
                    # agrega un insertado con exito al mensaje
                    $oks++;
                    //echo $response['response']['code'];
                }
            }
        }
        if (!is_numeric($desactivados)) {
            echo json_encode(array('response' => array('code' => 2, 'msj' => "No se ha podido reestablecer el contenido del paquete.")));
        } elseif ($oks == $len_detalle) {
            echo json_encode(array('response' => array('code' => 1, 'msj' => "Se insertaron todos los servicios.")));
        } else {
            echo json_encode(array('response' => array('code' => 2, 'msj' => "Es posible que se hayn omitido algunos servicios.")));
        }

        return;
        break;
    case 7:
        $precioPaquetes = $_POST['contenedorPaquetes']; #Forma de recibirlo

        $oks = 0;
        $fails = array();

        foreach ($precioPaquetes as $paquete) {

            $response = $master->updateByProcedure("sp_paquetes_actualizar_costo", [$paquete['id'], $paquete['costo'], $paquete['utilidad'], $paquete['total']]);

            if (is_numeric($response)) {
                $oks++;
            } else {
                $fails[] = $paquete[0];
            }
        }

        if ($oks == count($precioPaquetes)) {
            echo json_encode(array("response" => array("code" => 1, "msj" => "Se actualizaron todos los paquetes.")));
        } else {
            echo json_encode(array("response" => array("code" => 2, "fails" => $fails)));
        }
        exit;
        break;

    case 8:
        # asignar un paquete a un cliente
        $response = $master->updateByProcedure('sp_clientes_asignar_paquetes', array($cliente_id, $id_paquete));
        break;

    case 9:
        # buscar
        $response = $master->getByProcedure("sp_detalle_paquete_b", [$paquete, $cliente]);
        break;
    case 10:
        # eliminar servicios del paquete.
        $oks = 0;
        $fails = array();

        foreach ($eliminados as $e) {
            $response = $master->deleteByProcedure('sp_detalle_paquete_e', [$e['paquete_id'], $e['servicio_id']]);

            if (is_numeric($response)) {
                $oks++;
            } else {
                $fails[] = $e['servicio_id'];
            }
        }
        break;

    default:

        $response = "api no reconocida " . $api;
        break;
}

echo $master->returnApi($response);
