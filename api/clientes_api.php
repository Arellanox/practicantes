<?php
require_once "../clases/master_class.php";
require_once "../clases/token_auth.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    // $tokenVerification->logout();
    // exit;
}

#api
$api = $_POST['api'];

#buscar
$id = $_POST['id'];
$codigo = $_POST['codigo'];

#insertar
$id_cliente = $_POST['id_cliente'];
$nombre_comercial = $_POST['nombre_comercial'];
$razon_social = $_POST['razon_social'];
$nombre_sistema = $_POST['nombre_sistema'];
$rfc = $_POST['rfc'];
$curp = $_POST['curp'];
$abreviatura = $_POST['abreviatura'];
$limite_credito = $_POST['limite'];
$temporalidad_de_credito = $_POST['tiempo_credito'];
$cuenta_contable = $_POST['cuenta_contable'];
$pagina_web = $_POST['confac'];
$facebook = $_POST['Facebook'];
$twitter = $_POST['Twitter'];
$instagram = $_POST['Instagram'];
$regimen = $_POST['regimen'];
$convenio = $_POST['convenio'];
$qr = $_POST['qr'];
$cfdi = $_POST['cfdi'];

$parametros = array(
    $id_cliente,
    $regimen,
    $convenio,
    $nombre_comercial,
    $razon_social,
    $nombre_sistema,
    $rfc,
    $curp,
    $abreviatura,
    $limite_credito,
    $temporalidad_de_credito,
    $cuenta_contable,
    $pagina_web,
    $facebook,
    $twitter,
    $instagram,
    $codigo,
    $cfdi
);

$response = "";

$master = new Master();
switch ($api) {
    case 1:
        $response = $master->insertByProcedure("sp_clientes_g", $parametros);
        break;
    case 2:
        # buscar
        $response = $master->getByProcedure("sp_clientes_b", [$id, $codigo, $qr]);

        // si buscan solo un cliente se le agrega los segmentos disponibles
        if (count($response) == 1) {
            $segmentosResponse = $master->getByProcedure('fillSelect_segmentos', array($response[0]['ID_CLIENTE']));
            if (count($segmentosResponse) > 0) {
                $response[0][] = $segmentosResponse;
                $response['SEGMENTOS'] = $segmentosResponse;
            } else {
                $response[0][] = "Sin segmentos";
                $response[0]['SEGMENTOS'] = "Sin segmentos";
            }
        }
        break;
    case 3:
        # actualizar
        $response = $master->updateByProcedure("sp_clientes_g", $parametros);
        break;
    case 4:
        # desactivar
        $result = $master->deleteByProcedure("sp_clientes_e", [$id]);
        break;
    case 5:
        # creacion de qr de cliente
        #puedes buscar el cliente por codigo o por el id del cliente
        # enviar null para la variable que no se vaya a usar

        $cliente = array($id_cliente, $codigo, $qr);

        $result = $master->getByProcedure('sp_clientes_b', $cliente);
        $nombreCliente = $result[0]['NOMBRE_COMERCIAL'];
        $qr = "https://bimo-lab.com/nuevo_checkup/vista/registro/?codigo=" . $result[0]['QR'];

        $url = $master->generarQRURL("cliente", $qr, $nombreCliente, QR_ECLEVEL_H, 10);
        echo json_encode(array("url" => $url, "url_qr" => $qr, "nombre" => $nombreCliente));
        exit;

    default:
        $response = "api no reconocida";
        break;
}

echo $master->returnApi($response);
