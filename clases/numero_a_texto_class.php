<?php
// require_once '../vendor/autoload.php';

// use NumberToWords\NumberToWords;

// function convertirNumeroATexto($numero)
// {
//     $numberToWords = new NumberToWords();
//     $numberTransformer = $numberToWords->getNumberTransformer('es');

//     $texto = $numberTransformer->toWords($numero);

//     return $texto;
// }
class NumbersToLetters extends Miscelaneus
{
    public $letters;

    function NumbersToLetters($number)
    {
        $this->letters = $this->convertirCantidadALetras($number);
    }

    function convertirCantidadALetras($valor)
    {
        $entero_parte = floor($valor);
        $decimal_parte = round(($valor - $entero_parte) * 100);

        $entero_letras = "";
        $decimal_letras = "";
        $resultado = "";

        // Convertir la parte entera a letras
        if ($entero_parte == 0) {
            $entero_letras = "CERO";
        } else {
            $entero_letras = $this->convertirParteEntera($entero_parte);
        }

        // Convertir la parte decimal a letras
        $decimal_letras = $decimal_parte . "/100";

        // Combinar las partes en el resultado final
        $resultado = $entero_letras . " " . $decimal_letras;

        return $resultado;
    }

    function convertirParteEntera($numero)
    {
        $unidades = array(
            "", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE", "DIEZ",
            "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISÉIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE"
        );

        $decenas = array(
            "", "DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"
        );

        $centenas = array(
            "", "CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"
        );

        if ($numero < 20) {
            return $unidades[$numero];
        } elseif ($numero < 30) {
            return "VEINTI" . $this->convertirParteEntera($numero - 20);
        } elseif ($numero < 100) {
            return $decenas[floor($numero / 10)] . (($numero % 10 != 0) ? " Y " . $this->convertirParteEntera($numero % 10) : "");
        } elseif ($numero < 1000) {
            return $centenas[floor($numero / 100)] . (($numero % 100 != 0) ? " " . $this->convertirParteEntera($numero % 100) : "");
        } elseif ($numero < 1000000) {
            $mil = floor($numero / 1000);
            $resto = $numero % 1000;
            $resultado = "";

            if ($mil == 1) {
                $resultado .= "MIL";
            } elseif ($mil == 100) {
                $resultado .= "CIEN MIL";
            } elseif ($mil < 20) {
                $resultado .= $unidades[$mil] . " MIL";
            } elseif ($mil < 100) {
                $resultado .= $decenas[floor($mil / 10)] . (($mil % 10 != 0) ? " Y " . $unidades[$mil % 10] : "") . " MIL";
            } else {
                $resultado .= $this->convertirParteEntera($mil) . " MIL";
            }

            if ($resto != 0) {
                $resultado .= " " . $this->convertirParteEntera($resto);
            }

            return $resultado;
        } elseif ($numero < 1000000000) {
            $millones = floor($numero / 1000000);
            $resto = $numero % 1000000;
            $resultado = "";

            if ($millones == 1) {
                $resultado .= "UN MILLÓN";
            } elseif ($millones < 1000) {
                $resultado .= $this->convertirParteEntera($millones) . " MILLONES";
            }

            if ($resto != 0) {
                $resultado .= " " . $this->convertirParteEntera($resto);
            }

            return $resultado;
        }
    }
}


// Ejemplo de uso
// $cantidad = 10000000.00;

// // Creamos instancia de objeto pasando el decimal.
// $obj = new NumbersToLetters($cantidad);

// // Imprimimos el decimal en letras.
// echo $obj->letters;
