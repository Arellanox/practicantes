<?php
include "../interfaces/iMetodos.php";
require_once "../clases/token_auth.php";
include "../clases/precios_class.php";
include "../clases/clientes_class.php";
include "../clases/servicios_class.php";
include_once "../clases/master_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    $tokenVerification->logout();
    exit;
}


$master = new Master();
$api = $_POST['api'];
$cliente_id = $_POST['cliente_id'];
$datos = $_POST['servicios']; #esta variable debe guardar el id del servicios, el margen de utilidad y el precio de venta
$area_id = $_POST['area_id'];
$paquete_id = $_POST['paquete_id'];

# esta variable guarda el margen cuando se quiere actualizar el precio de venta de todos los servicios
# de un cliente dado.
$margen_global = $_POST['margen_global'];

switch ($api) {
    case 1:
        $precios = $_POST['contenedorListaPrecios']; #Nombre similar para la cantidad de paquetes
        for ($i = 0; $i < count($precios); $i++) {
            $new = $precios[$i];
            $response = $master->updateByProcedure('sp_servicios_lista_de_precios_g', $new);
        }
        if (is_numeric($response)) {
            echo json_encode(array("response" => array("code" => 1, "lastId" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;
    case 2:
        $response = $precio->getAll();

        if (is_array($response)) {
            $dataset = array();
            foreach ($response as $data) {
                $cliente = new Clientes();
                $servicio = new Servicios();

                $labelCliente = $cliente->getById($data['CLIENTE_ID']);
                $labelServicio = $servicio->getById($data['SERVICIO_ID']);

                $data['CLIENTE'] = $labelCliente;
                $data[] = $labelCliente;
                $data['SERVICIO'] = $labelServicio;
                $data[] = $labelServicio;

                $dataset[] = $data;
            }
            echo json_encode(array("response" => array("code" => 1, "data" => $dataset)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;
    case 3:
        $response = $precio->getById(1);
        if (is_array($response)) {
            $dataset = array();
            foreach ($response as $data) {
                $cliente = new Clientes();
                $servicio = new Servicios();

                $labelCliente = $cliente->getById($data['CLIENTE_ID']);
                $labelServicio = $servicio->getById($data['SERVICIO_ID']);

                $data['CLIENTE'] = $labelCliente;
                $data[] = $labelCliente;
                $data['SERVICIO'] = $labelServicio;
                $data[] = $labelServicio;

                $dataset[] = $data;
            }
            echo json_encode(array("response" => array("code" => 1, "data" => $dataset)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;
    case 4:
        $response = $precio->update($values);

        if (is_numeric($response)) {
            echo json_encode(array("response" => array("code" => 1, "affected" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;

    case 5:
        $response = $precio->delete(1);
        if (is_numeric($response)) {
            echo json_encode(array("response" => array("code" => 1, "affected" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;
    case 6:
        # asignar precios a un cliente, actualizar o eliminar alguno.
        # para eliminar algun precio enviar 0 en utilidad
        $fails = array();
        $oks = 0;

        foreach ($datos as $data) {
            $response = $master->insertByProcedure('sp_precios_g', [$cliente_id, $data['id'], $data['utilidad'], $data['total'], $data['costo']]);
            if (is_numeric($response)) {
                $oks++;
            } else {
                $fails[] = $data['servicio_id'];
            }
        }

        echo json_encode(array("response" => array("code" => (count($datos) == $oks ? 1 : $fails))));

        break;
    case 7:
        # recuperar la lista de precio de un cliente
        $response = $master->getByProcedure('sp_precios_b', [$cliente_id, $area_id, $paquete_id]);
        echo $master->returnApi($response);
        break;
    case 8:
        # actualizar lista de precios
        if (is_null($margen_global)) {
            # si no proporcionan un margen de utilidad para todos,
            # se actualiza uno por uno
            $fails = array();
            $oks = 0;

            foreach ($datos as $data) {
                if ($data['utilidad'] == 0) {
                    $oks++;
                } else {
                    $response = $master->updateByProcedure('sp_precios_g', [$cliente_id, $data['id'], $data['utilidad'], $data['total']]);
                    if (is_numeric($response)) {
                        $oks++;
                    } else {
                        $fails[] = $data['servicio_id'];
                    }
                }
            }

            echo json_encode(array("response" => (count($datos) == $oks ? 1 : $fails)));
            exit;
        } else {
            # si el margen de utilidad para todos es el mismo
            # solo se necesita el id del cliente
            $response = $master->updateByProcedure('sp_precios_a', [$cliente_id, null, null, null, $margen_global]);
            echo $master->returnApi($response);
        }
        break;
    case 9:
        # mostrar la lista de todos los servicios con el precio de venta
        # de acuerdo al cliente seleccionado y area seleccionada.
        # solo el [area] puede ser null, si se envia el cliente null, no devuelve nada.
        # Si se quiere recuperar los servicios de todas las areas enviar null en $area_id,
        # si se quiere recuperar "otros servicios" enviar 0, de lo contrario enviar el id del area
        # que corresponda.
        $response = $master->getByProcedure('sp_servicios_gral_precio_clientes_b', [$cliente_id, $area_id]);
        echo $master->returnApi($response);
        break;

    default:
        # code...
        echo "Api no reconocida.";
        break;
}
