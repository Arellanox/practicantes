<?php
include_once "master_class.php";
class TokenPreregistro
{


    public function generarTokenPreregistro($correo, $cuestionarios)
    {
        
        if (!(filter_var($correo, FILTER_VALIDATE_EMAIL))) {
            echo 'Invalid email';
        }

        $token = '';

        try {
            $master = new Master();
            $resSP = $master->getByProcedure("sp_preregistro_token_g", [null, $correo, null, json_encode($cuestionarios)]);
            $token = $resSP[0]['_token'];
        } catch (Exception $e) {
            // return ('Error: '  . $sentencia->errorCode());
            return ('Error: '  . $e);
        }
        return $token;
    }

    private function concatQuestionMark($length)
    {
        $questionMarks = "(";
        for ($i = 0; $i < $length; $i++) {
            if ($i == $length - 1) {
                $questionMarks .= "?";
            } else {
                $questionMarks .= "?,";
            }
        }

        $questionMarks .= ");";
        return $questionMarks;
    }

    private function bindParams($object, $params)
    {
        for ($i = 0; $i < count($params); $i++) {
            $object->bindParam(($i + 1), $params[$i]);
        }
        return $object;
    }
}
