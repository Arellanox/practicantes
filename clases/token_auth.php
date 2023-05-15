<?php
session_start(); 
class TokenVerificacion
{

 
    function verificar()
    {
        try {
            $master = new Master();
            $id_user =  $_SESSION['id'];
            $token_session =  $_SESSION['token'];
            $parametros = [$id_user, $token_session];
            $conexion = $master->connectDb();
            $sp = "call sp_usuarios_token_b". $this->concatQuestionMark(count($parametros));
            $sentencia = $conexion->prepare($sp);
            $sentencia = $this->bindParams($sentencia,$parametros);
            $sentencia->execute();
            $resultSet = $sentencia->fetchAll();
            $sentencia->closeCursor();
            if (count($resultSet)>0){
                return true;
            }
        } catch (Exception $e) {
            echo $sentencia->errorCode();
        }
        return false;
    }

    private function concatQuestionMark($length){
        $questionMarks = "(";
        for ($i=0; $i < $length; $i++) {
            if ($i==$length-1) {
                $questionMarks.="?";
            } else {
                $questionMarks.="?,";
            }
        }

        $questionMarks.=");";
        return $questionMarks;
    }

    private function bindParams($object, $params){
        for ($i=0; $i < count($params); $i++) {
            $object->bindParam(($i+1),$params[$i]);
        }
        return $object;
    }
    public function logout(){
        echo json_encode(array("response" => array("code" => "Token", "msj" => "Token no autorizado, inicio de sesión requerido")));
    }

}
