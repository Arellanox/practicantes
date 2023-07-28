<?php
include "../interfaces/iMetodos.php";
require_once "../clases/token_auth.php";
include_once "../clases/usuarios_class.php";
include "../clases/cargos_class.php";
include "../clases/tipos_usuarios_class.php";
include_once "../clases/master_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (!$tokenValido) {
    #$tokenVerification->logout();
    #exit;
}

$usuario = new Usuarios();
$master = new Master();

$api = isset($_POST['api']) ? $_POST['api'] : $_GET['api'];



#Datos insertar usuario
$id_usuario = $_POST['id_usuario'];
$cargo_id = $_POST['cargo'];
$tipo_id = $_POST['tipo'];
$nombre = $_POST['nombre'];
$paterno = $_POST['paterno'];
$materno = $_POST['materno'];
$username = $_POST['usuario'];
$contrasenia = $_POST['contraseña'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$bloqueado = $_POST['bloqueado'];
$titulo_id = $_POST['titulo'];
$universidad = $_POST['universidad'];
$profesion = $_POST['profesion'];
$cedula = $_POST['cedula'];



# especialidades
$id_especialidad = $_POST['id_especialidad'];
$id_u_especialidad = $_POST['id_u_especialidad'];
$especialidades = $_POST['especialidades']; #especialidad,universidad,cedula,certificado,certificado_num


switch ($api) {
    case 1:
        // $array_slice = array_slice($_POST, 0, 13);
        // $a = $usuario->master->mis->getFormValues($array_slice);
        // // $newRecord = array(4,1,"Josue","De la Cruz","Arellano","Arellanox","arditas","Ingeniero en TI");
        // $response = $usuario->insert($a);

        // if (is_numeric($response)) {
        //     echo json_encode(array("response" => array("code" => 1, "lastId" => $response)));
        // } else {
        //     echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        // }

        $opciones = [
            'cost' => 12,
        ];
        $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, $opciones);

        $params = array(
            $id_usuario,
            $cargo_id,
            $tipo_id,
            $nombre,
            $paterno,
            $materno,
            $username,
            $contrasenia,
            $profesion,
            $cedula,
            $telefono,
            $correo,
            $bloqueado,
            $titulo_id,
            $universidad
        );

        $last_id = $master->insertByProcedure('sp_usuarios_g', $params);
        if (count($especialidades) > 0) {
            foreach ($especialidades as $current) {
                $response = $master->insertByProcedure("sp_u_especialidades_g", [null, $last_id, $current['especialidad'], $current['cedula'], $current['universidad'], $current['certificado'], $current['certificado_num']]);
            }
        } else {
            $response = $last_id;
        }

        echo $master->returnApi($response);
        break;
    case 2:
        $response = $master->getByProcedure("sp_usuarios_b", [$id_usuario, $correo]);
        echo $master->returnApi($response);
        // $response = $usuario->getAll();

        // if (is_array($response)) {
        //     $completedUser = array();
        //     $i = 1;
        //     foreach ($response as $user) {
        //         $cargo = new Cargos();
        //         $tipo = new TiposUsuarios();
        //         $labelCargo = $cargo->getById($user["CARGO_ID"]);
        //         $labelTipo = $tipo->getById($user['TIPO_ID']);

        //         $user['cargo'] = $labelCargo;
        //         $user['tipo'] = $labelTipo;
        //         $user['nombrecompleto'] = $user['NOMBRE'] . " " . $user['PATERNO'] . " " . $user['MATERNO'];
        //         $user['count'] = $i;
        //         $user['ACTIVO'] = $user['BLOQUEADO'] ? "INACTIVO" : "ACTIVO";
        //         $i++;
        //         $completedUser[] = $user;
        //     }
        //     echo json_encode($completedUser);
        // } else {
        //     echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        // }

        // $response = $master->getByProcedure('', []);
        break;

    case 3:
        # eliminar especialidad de una usuario
        $response = $master->deleteByProcedure("sp_usuarios_especialidades_e", [$id_usuario, $id_especialidad]);
        echo $master->returnApi($response);

        // $response  = $usuario->getById($_POST['id']);
        // if (is_array($response)) {
        //     $completedUser = array();

        //     foreach ($response as $user) {
        //         $cargo = new Cargos();
        //         $tipo = new TiposUsuarios();
        //         $labelCargo = $cargo->getById($user["CARGO_ID"]);
        //         $labelTipo = $tipo->getById($user['TIPO_ID']);

        //         $user['cargo'] = $labelCargo;
        //         $user['tipo'] = $labelTipo;

        //         $completedUser[] = $user;
        //     }
        //     echo json_encode(array("response" => array("code" => 1, "data" => $completedUser)));
        // } else {
        //     echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        // }
        // break;

    case 4:
        $array_slice = array_slice($_POST, 0, 11);
        $a = $usuario->master->mis->getFormValues($array_slice);
        $response = $usuario->update($a);

        if (is_numeric($response)) {
            echo json_encode(array("response" => array("code" => 1, "affected" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;
    case 5:
        $response = $usuario->delete($_POST['id']);
        if (is_numeric($response)) {
            echo json_encode(array("response" => array("code" => 1, "affected" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;
    case 6:
        // Iniciar sesión
        $response = $usuario->startSession($_POST['user'], $_POST['pass']);

        if (is_array($response)) {
            echo json_encode(array("response" => array("code" => 1, "data" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 'login', "msj" => $response)));
        }
        break;
    case 7:
        //Actualizar estado del usuario
        $response = $usuario->estadoUsuario($_POST['id'], $_POST['estado']);
        if (is_numeric($response)) {
            echo json_encode(array("response" => array("code" => 1, "data" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 2, "msj" => $response)));
        }
        break;
    case 8:
        $response = $usuario->validarUsuario($_SESSION['id']);
        if ($response != 0) {
            echo json_encode(array("response" => array("code" => 1, "data" => $response)));
        } else {
            echo json_encode(array("response" => array("code" => 'Usernovalid', "data" => $response)));
        }
        break;

    case 9:
        # confirmar con contrasenia los resultados de laboratorio
        $activo = 1;
        $bloqueado = 0;
        $user = $_SESSION['user'];
        $parametros = [$user, $activo, $bloqueado];
        $result = $master->getByProcedure("sp_usuarios_login_b", $parametros);
        $password = $_GET['password'];

        if (count($result) > 0) {
            if (password_verify($password, $result[0]['CONTRASENIA'])) {
                echo json_encode(array("status" => 1));
            } else {
                echo json_encode(array("status" => 0));
            }
        } else {
            echo json_encode(array("status" => 'No se encuentra el usuario.'));
        }



        break;
    case 10:
        #insertar especialidades para medicos/ actualizar especialidades
        $response = $master->insertByProcedure("sp_u_especialidades_g", [$id_u_especialidad, $id_usuario, $especialidad_id, $cedula, $universidad, $certificado_por]);

        echo $master->returnApi($response);
        break;

    case 11:
        # buscar especialidades
        $response = $master->getByProcedure("sp_u_especialidades_b", [$id_u_especialidad, $id_usuario]);

        echo $master->returnApi($response);
        break;
    case 12:
        # eliminar especialidad
        $response = $master->deleteByProcedure("sp_u_especialidades_e", [$id_u_especialidad]);

        echo $master->returnApi($response);
        break;

    case 13:
        # Actualizar contrasenia

        $opciones = [
            'cost' => 12,
        ];
        $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, $opciones);
        $response = $master->updateByProcedure('sp_usuarios_actualizar_password', [$id_usuario, $contrasenia]);
        echo $master->returnApi($response);
        break;
    default:
        # code...
        break;
}
