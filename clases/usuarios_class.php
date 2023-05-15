<?php
include_once "master_class.php";

class Usuarios extends Master implements iMetodos
{
    public $id_usuario; #11
    public $cargo_id; #0
    public $tipo_id; #1
    public $nombre; #2
    public $paterno; #3
    public $materno; #4
    public $usuario; #5
    public $contrasenia; #6
    public $profesion; #7
    public $cedula; #8
    public $telefono; #9
    public $correo; #10
    // public $bloqueado;
    public $titulo_id; #12
    public $universidad; #13
    public $activo;
    private $tabla;
    private $public_attributes;
    public $master;
    private $intergers;
    private $strings;
    private $doubles;
    private $intergers_update;
    private $nulls;



    function Usuarios()
    {
        $this->tabla = "usuarios";
        $this->public_attributes = 13;
        $this->master = new Master();
        $this->intergers = array(0, 1, 9);
        $this->strings = array(2, 3, 4, 5, 6, 7, 8, 10);
        $this->doubles = array();
        $this->intergers_update = array(0, 1, 9, 11);
        $this->nulls = array(7, 9, 3, 4, 10, 8);
    }

    function getAttributes()
    {
        $array = array();

        $count = 0;
        foreach ($this as $key => $value) {
            if ($count < $this->public_attributes) {
                $array[] = $key;
            }
            $count = $count + 1;
        }

        return $array;
    }

    function insert($values)
    {
        $opciones = [
            'cost' => 12,
        ];
        $values[6] = password_hash($values[6], PASSWORD_BCRYPT, $opciones);

        $response = $this->master->insert($this->tabla, $this->getAttributes(), $values, $this->intergers, $this->strings, $this->doubles, $this->nulls);
        return $response;
    }


    function getAll()
    {
        $response = $this->master->getAll($this->tabla);
        return $response;
    }

    function getById($id)
    {
        $response = $this->master->getById($this->tabla, $id, $this->getAttributes());
        return $response;
    }

    function update($values)
    {
        $conn = $this->master->connectDb();
        $sql = "UPDATE $this->tabla SET cargo_id=?,tipo_id=?,nombre=?,paterno=?,materno=?,usuario=?,profesion=?,cedula=?,telefono=?,correo=? WHERE id_usuario=?";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $values[0]);
        $stmt->bindParam(2, $values[1]);
        $stmt->bindParam(3, $values[2]);
        $stmt->bindParam(4, $values[3]);
        $stmt->bindParam(5, $values[4]);
        $stmt->bindParam(6, $values[5]);
        $stmt->bindParam(7, $values[6]);
        $stmt->bindParam(8, $values[7]);
        $stmt->bindParam(9, $values[8]);
        $stmt->bindParam(10, $values[9]);
        $stmt->bindParam(11, $values[10]);

        if (!$stmt->execute()) {
            return "Error al actualizar datos. (" . $stmt->errno . "). " . $stmt->error;
        }

        return $stmt->rowCount();
    }

    function delete($id)
    {
        $response = $this->master->delete($this->tabla, $this->getAttributes(), $id);
        return $response;
    }

    function startSession($user, $password)
    {
        $conn = $this->master->connectDb();
        $activo = 1;
        $bloqueado = 0;
        $stmt = $conn->prepare("SELECT * FROM $this->tabla WHERE BINARY usuario = ? and activo = ? and bloqueado = ?");
        $error_tipo_dato = $this->master->mis->validarDatos(array($user), array(), array(0), array(), array());

        if (count($error_tipo_dato) > 0) {
            return "Error en el tipo de datos de usuario.";
        }

        $stmt->bindParam(1, $user);
        $stmt->bindParam(2, $activo);
        $stmt->bindParam(3, $bloqueado);

        if (!$stmt->execute()) {
            $error = "Ha ocurrido un error (" . $stmt->errno . "). " . $stmt->error;
            return $error;
        }

        $result = $stmt->fetchAll();
        // print_r($user);
        if (count($result) > 0) {
            if (password_verify($password, $result[0]['CONTRASENIA'])) {
                session_start();
                $_SESSION['id'] = $result[0]['ID_USUARIO'];
                $_SESSION['nombre'] = $result[0]['NOMBRE'];
                $_SESSION['apellidos'] = $result[0]['PATERNO'] . " " . $result[0]['MATERNO'];
                $_SESSION['user'] = $result[0]['USUARIO'];
                $_SESSION['perfil'] = $result[0]['TIPO_ID'];

                //Permisos
                $sql = "SELECT pertip.DESCRIPCION, permisos.activo
                        FROM usuarios_permisos as permisos
                        LEFT JOIN permisos as pertip ON pertip.ID_PERMISO = permisos.PERMISO_ID
                        WHERE permisos.USUARIO_ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $_SESSION['id']);
                $stmt->execute();
                $permisos = array();
                $result = $stmt->fetchAll();
                for ($i = 0; $i < count($result); $i++) {
                    $permisos[$result[$i]['DESCRIPCION']] = $result[$i]['activo'];
                }
                $_SESSION['permisos'] = $permisos;

                // Areas
                $sql = "SELECT areatip.DESCRIPCION, area.activo
                        FROM usuarios_areas as area
                        LEFT JOIN areas as areatip ON areatip.ID_AREA = area.AREA_ID
                        WHERE area.USUARIO_ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $_SESSION['id']);
                $stmt->execute();
                $vista = array();
                $result = $stmt->fetchAll();
                for ($i = 0; $i < count($result); $i++) {
                    $vista[$result[$i]['DESCRIPCION']] = $result[$i]['activo'];
                }
                $_SESSION['vista'] = $vista;


                return $_SESSION;
            } else {
                return "Oops! Tu contraseña es incorrecta.";
            }
        } else {
            return "Usuario y/o contraseña incorrectos.";
        }
    }

    function changePassword($newPassword, $id)
    {
        $conn = $this->master->connectDb();

        $sql = "UPDATE $this->tabla SET contrasenia=? WHERE id_usuario=?";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $newPassword);
        $stmt->bindParam(2, $id);

        if (!$stmt->execute()) {
            $error = "Ha ocurrido un error (" . $stmt->errorCode() . "). " . implode(" ", $stmt->errorInfo());
            return $error;
        }

        return $stmt->rowCount();
    }

    function estadoUsuario($id, $estado)
    {
        $conn = $this->master->connectDb();
        $sql = "UPDATE $this->tabla SET BLOQUEADO = ? WHERE ID_USUARIO = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $estado);
        $stmt->bindParam(2, $id);
        if (!$stmt->execute()) {
            return "Ha ocurrido un error (" . $stmt->errorCode() . "). " . implode(" ", $stmt->errorInfo());
        }
        // $response = $this->master->delete($this->tabla,$this->getAttributes(),$id);
        return 1;
    }

    function validarUsuario($id)
    {
        $conn = $this->master->connectDb();
        $sql = "SELECT TIPO_ID FROM $this->tabla WHERE ID_USUARIO = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id);
        if (!$stmt->execute()) {
            return "Ha ocurrido un error (" . $stmt->errorCode() . "). " . implode(" ", $stmt->errorInfo());
        }
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return $result[0]['TIPO_ID'];
        } else {
            session_start();
            session_unset();
            session_destroy();
            return 0;
        }
    }
}
