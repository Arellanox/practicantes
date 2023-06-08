<?php
include "../interfaces/iMetodos.php";
require_once "../clases/token_auth.php";
include "../clases/usuarios_permisos_class.php";
include "../clases/usuarios_class.php";
include "../clases/permisos_class.php";

$tokenVerification = new TokenVerificacion();
$tokenValido = $tokenVerification->verificar();
if (! $tokenValido){
    $tokenVerification->logout();
    exit;
}


$permission = new PermisosUsuarios();
$api = $_POST['api'];

switch ($api) {
    case 1:
        $array_slice = array_slice($_POST,0,2);
        $a = $permission->master->mis->getFormValues($array_slice);
        $response = $permission->insert($a);

        if(is_numeric($response)){
            echo json_encode(array("response"=>array("code"=>1,"lastId"=>$response)));
        } else {
            echo json_encode(array("response"=>array("code"=>2,"msj"=>$response)));
        }
        break;
    case 2:
        $response = $permission->getAll();

        if(is_array($response)){
            $dataset = array();

            foreach ($response as $value) {
                $usuario = new Usuarios();
                $permiso = new Permisos();
                $usuarioLabel = $usuario->getById($value['USUARIO_ID']);
                $permisoLabel = $permiso->getById($value['PERMISO_ID']);

                $value['USUARIO'] = $usuarioLabel;
                $value[] = $usuarioLabel;
                $value['PERMISO'] = $permisoLabel;
                $value[] = $permisoLabel;

                $dataset[] = $value;
            }
            echo json_encode(array("response"=>array("code"=>1,"data"=>$dataset)));
        } else {
            echo json_encode(array("response"=>array("code"=>2,"msj"=>$response)));
        }
        break;
    case 3:
        $response = $permission->getById(1);

        if(is_array($response)){
            $dataset = array();

            foreach ($response as $value) {
                $usuario = new Usuarios();
                $permiso = new Permisos();
                $usuarioLabel = $usuario->getById($value['USUARIO_ID']);
                $permisoLabel = $permiso->getById($value['PERMISO_ID']);

                $value['USUARIO'] = $usuarioLabel;
                $value[] = $usuarioLabel;
                $value['PERMISO'] = $permisoLabel;
                $value[] = $permisoLabel;

                $dataset[] = $value;
            }
            echo json_encode(array("response"=>array("code"=>1,"data"=>$dataset)));
        } else {
            echo json_encode(array("response"=>array("code"=>2,"msj"=>$response)));
        }
        break;
    case 4:
        $response = $permission->update($form);

        if(is_numeric($response)){
            echo json_encode(array("response"=>array("code"=>1,"affected"=>$response)));
        } else {
            echo json_encode(array("response"=>array("code"=>2,"msj"=>$response)));
        }
        break;
    case 5:
        $array_slice = array_slice($_POST,0,3);
        $a = $permission->master->mis->getFormValues($array_slice);
        $response = $permission->delete($a);

        if(is_numeric($response)){
            echo json_encode(array("response"=>array("code"=>1,"affected"=>$response)));
        } else {
            echo json_encode(array("response"=>array("code"=>1,"affected"=>$response)));
        }
        break;
    case 6:
        #Recuperar todos los permisos que tiene un usuario
        $response = $permission->getPermisosByUsuario($_POST['id']);

        if (is_array($response)) {
            echo json_encode(array("response"=>array("code"=>1,"data"=>$response)));
        } else {
            echo json_encode(array("response"=>array("code"=>2,"msj"=>$response)));
        }
        break;


    default:
        # code...
        break;
}
?>
