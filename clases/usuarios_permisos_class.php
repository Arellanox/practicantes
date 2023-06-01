<?php
include_once "master_class.php";

class PermisosUsuarios extends Master implements iMetodos{
    public $id_usuario_permiso;#2
    public $usuario_id;#0
    public $permiso_id;#1
    public $activo;
    public $master;
    private $tabla;
    private $public_attributes;
    private $intergers;
    private $strings;
    private $doubles;
    private $intergers_update;
    private $nulls;

    function PermisosUsuarios(){
        $this->tabla = "usuarios_permisos";
        $this->intergers = array(0,1);
        $this->strings = array();
        $this->doubles = array();
        $this->nulls = array();
        $this->intergers_update = array(0,1,2);
        $this->master = new Master();
        $this->public_attributes = 4;
    }

    function getAttributes(){
        $array = array();

        $count = 0;
        foreach($this as $key=>$value){
            if($count<$this->public_attributes){
                $array[] = $key;
            }
            $count = $count + 1;
        }

        return $array;
    }

    function insert($values){
        $conn = $this->master->connectDb();
        $sql = "SELECT * FROM $this->tabla WHERE USUARIO_ID = ? AND PERMISO_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt ->bindParam(1, $values[0]);
        $stmt ->bindParam(2, $values[1]);
        if (!$stmt->execute()) {
          return "Ha ocurrido un error: La verificación del permiso no ha sido ejecutada";
        }
        $i = $stmt -> fetchAll();
        if (count($i)>0) {
          $values[] = 1;
          $response = $this ->delete($values);
        }else{
          $response = $this->master->insert($this->tabla,$this->getAttributes(),$values,$this->intergers,$this->strings,$this->doubles,$this->nulls);
        }
        return $response;
    }

    function getAll(){
        $response = $this->master->getAll($this->tabla);
        return $response;
    }

    function getById($id){
        $response = $this->master->getById($this->tabla,$id,$this->getAttributes());
        return $response;
    }

    function update($values){
        $response = $this->master->update($this->tabla,$this->getAttributes(),$values,$this->intergers_update,$this->strings,$this->doubles,$this->nulls);
        return $response;
    }

    function delete($values){
        $conn = $this->master->connectDb();
        $sql = "UPDATE $this->tabla SET activo = ? WHERE USUARIO_ID = ? AND PERMISO_ID = ?";
        $stmt = $conn -> prepare($sql);
        $stmt ->bindParam(1, $values[2]);
        $stmt ->bindParam(2, $values[0]);
        $stmt ->bindParam(3, $values[1]);
        if (!$stmt->execute()) {
          return "Ha ocurrido un error (".$stmt->errorCode()."). ".implode(" ",$stmt->errorInfo());
        }
        // $response = $this->master->delete($this->tabla,$this->getAttributes(),$id);
        return 1;
    }

    function getPermisosByUsuario($usuario){
        $conn = $this->master->connectDb();
        $sql = "SELECT * FROM $this->tabla WHERE activo=? and usuario_id=?";
        $activo = 1;

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$activo);
        $stmt->bindParam(2,$usuario);

        if(!$stmt->execute()){
            return "Error al recuperar los permisos del usuario.";
        }

        return $stmt->fetchAll();
    }
}
?>
