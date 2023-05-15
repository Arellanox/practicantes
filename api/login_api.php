<?php
session_start();
include "../clases/master_class.php";
// include "../clases/correo_class.php";

$api = $_POST['api'];
$master = new Master();
$id_usuario = $_POST['id_usuario'];
$contrasenia = $_POST['contraseña'];
switch ($api) {
    case 1:
        $_SESSION = array();
        $response = login($_POST['user'], $_POST['pass']);
        if (is_array($response)) {
            $token = generarToken($_SESSION['id']);
            // echo json_encode([$token]);
            if (!is_null($token)) {
                echo json_encode(array("response" => array("code" => 1, "data" => $response, "token" => $token, "session" => $_SESSION)));
            } else {
                echo json_encode(array("response" => array("code" => 'login', "msj" => "token no generado")));
            }
        } else {
            echo json_encode(array("response" => array("code" => 'login', "msj" => $response)));
        }
        break;
    case 2:
        $_SESSION = array();

        // if(init_get("session.use_cookies")){
        //     $params = session_get_cookie_params();
        //     setcookie(session_name(),'',time() - 42000,
        //     $params["path"],$params["domain"],$params["secure"],$params["httponly"]);
        // }

        unset($_COOKIE);

        if (session_destroy()) {
            echo json_encode(array("response" => array("code" => '1', "msj" => "logout")));
        } else {
            echo json_encode(array("response" => array("code" => '2', "msj" => "errors")));
        }
        break;
    case 3:
        # recuperar password olvidada
        $master = new Master();
        $correo = $_POST['correo'];
        $response = $master->getByProcedure("sp_usuarios_b", [null, $correo]);

        // if (is_array($response)) {
        //     $mail = new Correo();
        //     $r = $mail->sendEmail("password", "¡Bimer! Recupera tu password", [$correo], $response[array_key_first($response)]["ID_USUARIO"]);

        //     if ($r) {
        //         $master->setLog("Correo para recuperar password enviado.", "[logina_api case 3]");
        //     }
        // }

        echo $master->returnApi(1);

        break;

    case 4:
        # Actualizar contrasenia
        $opciones = [
            'cost' => 12,
        ];
        $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, $opciones);
        $response = $master->updateByProcedure('sp_usuarios_actualizar_password', [$id_usuario, $contrasenia]);
        echo $master->returnApi($response);
        break;
}



function generarToken($id_usuario)
{
    $tokenArray = array("id_usuario" => $id_usuario, "token" => uniqid());
    $token = hash("sha1", implode("_", $tokenArray), false);

    if (guardarUserToken($id_usuario, $token)) {
        //setcookie("token", $token);
        $_SESSION['token'] = $token;
        return $token;
    } else {
        return null;
    }
}

function guardarUserToken($token, $id_usuario)
{
    $master = new Master();
    $parametros = [$token, $id_usuario];
    $response = $master->updateByProcedure("sp_usuarios_token_g", $parametros);

    if (is_numeric($response)) {
        return true;
    } else {
        return false;
    }
}


function login($user, $password)
{
    $master = new Master();
    $activo = 1;
    $bloqueado = 0;
    $parametros = [$user, $activo, $bloqueado];
    $result = $master->getByProcedure("sp_usuarios_login_b", $parametros);

    if (count($result) > 0) {
        if (password_verify($password, $result[0]['CONTRASENIA'])) {
            $conn = $master->connectDb();
            $_SESSION['id'] = $result[0]['ID_USUARIO'];
            $_SESSION['nombre'] = $result[0]['NOMBRE'];
            $_SESSION['apellidos'] = $result[0]['PATERNO'] . " " . $result[0]['MATERNO'];
            $_SESSION['user'] = $result[0]['USUARIO'];
            $_SESSION['perfil'] = $result[0]['TIPO_ID'];
            $_SESSION['cargo'] = $result[0]['CARGO_ID'];


            $_SESSION['cargo_descripcion'] = $result[0]['DESCRIPCION'];

            //Avatar
            if (isset($result[0]['AVATAR'])) {
                $_SESSION['AVATAR'] = $result[0]['AVATAR'];
            } else {
                $_SESSION['AVATAR'] = 'https://bimo-lab.com/nuevo_checkup/archivos/sistema/avatar.svg';
            }


            //Permisos
            $sql = "SELECT pertip.DESCRIPCION, permisos.activo, pertip.permiso
                    FROM usuarios_permisos as permisos
                    LEFT JOIN permisos as pertip ON pertip.ID_PERMISO = permisos.PERMISO_ID
                    WHERE permisos.USUARIO_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_SESSION['id']);
            $stmt->execute();
            $permisos = array();
            $result = $stmt->fetchAll();
            for ($i = 0; $i < count($result); $i++) {
                // $permisos[$result[$i]['DESCRIPCION']] = $result[$i]['activo'];
                $permisos[$result[$i]['permiso']] = $result[$i]['activo']; //ABREVIATURA COMO IDENTIFICADOR DEL PERMISO
            }
            $_SESSION['permisos'] = $permisos;

            // Areas
            $sql = "SELECT areatip.DESCRIPCION, modulo.activo
            FROM usuarios_modulos as modulo
            LEFT JOIN modulos  as areatip ON areatip.ID_MODULO = modulo.MODULO_ID
            WHERE modulo.USUARIO_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_SESSION['id']);
            $stmt->execute();
            $vista = array();
            $result = $stmt->fetchAll();
            for ($i = 0; $i < count($result); $i++) {
                $vista[$result[$i]['DESCRIPCION']] = $result[$i]['activo']; //Eliminar luego
                $vista[$result[$i]['permiso']] = $result[$i]['activo'];
            }
            $_SESSION['vista'] = $vista;
            $_SESSION['pacientes_llamados'] = null;


            #Newsletter dinamico
            $sql = "SELECT nb.URL, nb.DESCRIPCION, nb.ACTIVO_BOTON
                    FROM NEWSLETTER_BIMO nb WHERE ACTIVO_BOTON = 1 ORDER BY id_newsletter_bimo ASC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $_SESSION['id']);
            $stmt->execute();
            $vista = array();
            $result = $stmt->fetchAll();
            $_SESSION['newsletter'] = [
                'button_usuario' => [
                    'url' => $result[0]['URL'],
                    'tittle_button' => $result[0]['DESCRIPCION'],
                ]
            ];


            return $_SESSION;
        } else {
            return "Oops! Tu contraseña es incorrecta.";
        }
    } else {
        return "Usuario y/o contraseña incorrectos.";
    }
}
