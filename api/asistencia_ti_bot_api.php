<?php
include_once "../clases/master_class.php";
include_once "../clases/correo_class.php";
include_once "../clases/token_auth.php";

class Whatsapp
{
  public function MetodoWhatsapp($mensaje)
  {
    $params = array(
      'token' => 'edgo0h81kywa8qmg',
      'to' => '120363138555833074@g.us',
      'body' => $mensaje,
      'priority' => '10',
      'referenceId' => '',
      'msgId' => '',
      'mentions' => ''
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.ultramsg.com/instance53560/messages/chat",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => http_build_query($params),
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return [2, "cURL Error #:" . $err];
    } else {
      return [1, $response];
    }
  }
}

$master = new Master();
$correo = new Correo();

$datos = json_decode(file_get_contents('php://input'), true);


$api = isset($datos['api']) ? $datos['api'] : $_POST['api'];


#insertar datos
$msj = $datos['msj'];
$nombre_usuario = $datos['nombre_usuario'];
$numero_usuario = $datos['numero_usuario'];
$token = $datos['token'];

//buscar los datos
$estatus_id = isset($datos['estatus_id']) ? $datos['estatus_id'] : $_POST['estatus_id'];

$fecha_creacion = $datos['fecha_creacion'];
$tendido_por = $datos['_tendido_por'];
$numero_usuario = $datos['numero_usuario'];

//actualizar estatus
$ticket = isset($datos['ticket']) ? $datos['ticket'] : $_POST['ticket'];
$atendido_por = $_SESSION['id'];

$fh = fopen("log.txt", 'a');
fwrite($fh, json_encode($datos));
fclose($fh);

$parametros = $master->setToNull(array(
  $msj,
  $nombre_usuario,
  $numero_usuario,
  $token
));

$buscarDatos = array(
  $estatus_id,
  $fecha_creacion,
  $tendido_por,
  $numero_usuario
);

$actualizarEstatus = array(
  $estatus_id,
  $ticket,
  $atendido_por
);

// echo json_encode(['result' => '99999']);
switch ($api) {

    //Inserta en el bot de WhatsApp
  case 1:
    $codigo = 0;
    $response = $master->insertByProcedure("sp_asistencia_ti_bot_g", $parametros);

    $objeto = new Whatsapp();
    if ($response > 0) {
      $response = ["TICKET" => $response];

      $correo_cath = $objeto->MetodoWhatsapp("$nombre_usuario necesita de tu ayuda! #Ticket: " . $response['TICKET']);

      if ($correo_cath[0] != 1) {
        $razon_envio = "$nombre_usuario necesita de tu ayuda!! #Ticket: " . $response['TICKET'];

        $correo->sendEmail("soporte_ti", "Asistente virtual TI", ["luis.cuevas@bimo.com.mx", "josue.delacruz@bimo.com.mx", "monica.gallegos@bimo-lab.com"], $correo_cath[1] . ". " . $razon_envio);
      }
    } else {
      $correo_cath = $objeto->MetodoWhatsapp("$nombre_usuario intento hacer un ticket pero no lo logró.");

      $razon_envio = "$nombre_usuario intento hacer un ticket pero no lo logró.";
      $correo->sendEmail("soporte_ti", "Asistente virtual TI", ["luis.cuevas@bimo.com.mx", "josue.delacruz@bimo.com.mx", "monica.gallegos@bimo-lab.com"], $correo_cath[1] . ". " . $razon_envio);
    }

    break;
  case 2:
    //traer los datos
    $response = $master->getByProcedure("sp_asistencia_ti_bot_b", []);
    echo $master->returnApi($response);
    exit;
    break;

  case 3:
    $response = $master->updateByProcedure("sp_bot_cambiar_estatus", $actualizarEstatus);
    echo $master->returnApi($response);
    exit;
    break;

  case 4:
    $response = $master->getByProcedure("sp_vista_ticket_bot_b", []);
    echo $master->returnApi($response);
    exit;
    break;

  default:
    $response = "API no definida";
    break;
}

echo $master->returnApi($response);
