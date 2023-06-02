<?php
include "./con_db.php";

function fechaCastellano ($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $numeroDia." de ".$nombreMes." de ".$anio; //$nombredia." ".
}

// echo fechaCastellano("2022/12/14");

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Panel Respiratorio</title>
</head>
<style>
    body{
        /* font-size: 11px; */
    }

    tr {
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .cuartos{
        width: 25%;
    }

    .venticinco{
        width: 25%;
    }

    .setentaycinco{
        width: 75%;
    }

    .footer{
        position: fixed;
        bottom: -40px;
        left: 0px;
        right: 0px;
    }
    .bold{
        font-weight: bold;
    }
    .cursive{
        /* font-style: italic; */
    }
    .rojo{
        color: red;
    }
    .resultados_resp td{
        width: 33.3%;
    }
</style>
<body>
    <div class="container-fluid">
        <table style="width: 100%;">
            <tr>
                <td style="width: 66.6%; text-align: center;">
                    <h4>DIAGNOSTICO BIOMOLECULAR<br>
                    Laboratorio de Biología Molecular<br>
                    Resultado de Exámenes</h4></td>
                <td style="width: 33.3%"><img src="http://bimo-lab.com/pdf/logo/logo_documento.png" alt="" width="" height=""></td>
            </tr>
        </table>
        <hr style="height: 3px; background-color: black ;">
        <h4 style="text-align: center; margin: -4px;"><strong>Biología Molecular</strong></h4>
        <hr style="height: 3px; background-color: black ;">
        <br>
        <table style="width: 100%; border-spacing: 4px;">
            <tr>
                <td colspan="2"><strong>No. Identificación:</strong></td>
                <td colspan="6">DBVMxxxx</td>
                <td><strong>Edad:</strong></td>
                <td>xx AÑOS</td>
                <td><strong>Sexo:</strong></td>
                <td>FEMENINO</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Nombre:</strong></td>
                <td colspan="6">Fulanito de Tal</td>
                <td colspan="2"><strong>Fecha de nacimiento:</strong></td>
                <td colspan="2">xxxx-xx-xx</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Fecha de toma de muestra:</strong></td>
                <td colspan="6">xxxx-xx-xx</td>
                <td colspan="2"><strong>Fecha de resultado:</strong></td>
                <td colspan="2">11/06/2022</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Tipo de muestra:</strong></td>
                <td colspan="6">CERVICAL</td>
                <td colspan="2"><strong>Pasaporte:</strong></td>
                <td colspan="2">xxxxxxxxxx</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Procedencia:</strong></td>
                <td colspan="4">PARTICULAR</td>
                <td colspan="3" style="text-align: center;"><strong>Médico <br> tratante:</strong></td>
                <td colspan="3">A QUIEN CORRESPONDA</td>
            </tr>
        </table>
        <!-- <p style="background-color: darkgrey; padding: 5px;text-align: center;"><strong>INFORMACIÓN CLÍNICA</strong></p> -->
        <br>
        <table class="resultados_resp" style="width: 100%; border-collapse: collapse; text-align: center; ">
            <tr style="background-color: darkgrey;" class="bold">
                <td colspan="4"><h3 style="margin-bottom: 0px;">Prueba</h3></td>
                <td colspan="4"><h3 style="margin-bottom: 0px;">Resultado</h3></td>
                <td colspan="4"><h3 style="margin-bottom: 0px;">Valor de Normalidad</h3></td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr class="bold">
                <td colspan="4" style="text-align: left;">Antidoping 5 Parametros</td>
                <td colspan="4"></td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;" class="cursive">OPIACEOS (OPI)</td>
                <td colspan="4" class="bold rojo">NEGATIVO</td>
                <td colspan="4">NEGATIVO</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;" class="cursive">METANFETAMINAS (MET)</td>
                <td colspan="4" class="bold">NEGATIVO</td>
                <td colspan="4">NEGATIVO</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;" class="cursive">COCAINA (COC)</td>
                <td colspan="4" class="bold">NEGATIVO</td>
                <td colspan="4">NEGATIVO</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;" class="cursive">ANFETAMINAS (AMP)</td>
                <td colspan="4" class= "bold">NEGATIVO</td>
                <td colspan="4">NEGATIVO</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;">CANNABINOIDES (THC)</td>
                <td colspan="4" class= "bold">NEGATIVO</td>
                <td colspan="4">NEGATIVO</td>
            </tr>
        </table>
        <p><strong>Comentarios:</strong> Esta prueba identifica la presencia  y el médico tratante es quien realiza
         la interpretación de este resultado de acuerdo a los datos clínicos que el paciente presente.
        </p>

        <br>
        <table style="width: 100%;">
            <tr>
                <td colspan="1" class="bold" style="width: 15% ;">Lote kit:</strong></td>
                <td colspan="1">0</strong></td>
                <td colspan="1" class="bold" style="width: 15% ;">ID de Frasco:</strong></td>
                <td colspan="1">0</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="bold" style="width: 15% ;">Kit utilizado:</strong></td>
                <td colspan="1"></strong></td>
                <td colspan="1" class="bold" style="width: 15% ;"> Registro Sanitario:</td>
                <td colspan="1"> </td>
            </tr>
        </table> 
        <br>
        <table>
                <tbody>
                    <tr class="col-foot-one">
                        <td colspan="12" style="text-align: center; padding-right: 0;"><strong>Atentamente</strong></td>
                    </tr>
                    <tr class="col-foot-two" >
                        <td colspan="3" style="text-align: center; ">
                            <a target="_blank" href="<?php echo $qr[0]; ?>"> <img style="margin-bottom: -30px" src='<?= $qr[1] ?>' alt='QR Code' width='110' height='110'> </a>
                        </td>
                        <td colspan="3" style="text-align: left;">
                            <?php echo "<img style='position:absolute;' src='data:image/png;base64, " . $encode_firma . "' height='80px'> " ?>
                        </td>
                    </tr>
                    <tr class="col-foot-three"  style="font-size: 13px;">
                        <td colspan="12" style="text-align: center; width: 50%; ">
                            <strong >Q.F.B. NERY FABIOLA ORNELAS RESENDIZ    <br>UPCH - Cédula profesional: 09291445</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr style="margin-top: 0px; height: 0.5px; background-color: black ;">
            <p style="text-align: center; margin-top: 0px"><small><strong>Avenida José Pagés Llergo No. 150  Interior 1, Colonia Arboledas, Villahermosa Tabasco, C.P. 86079, Teléfono: 993 131 00 42 
            Correo electrónico: hola@bimo.com.mx</strong></small></p>
        <!-- <footer>
            <table style="width: 100%;">
                <tr>
                    <td colspan="2" style="text-align: right; padding-right: 5rem;"><strong>Atentamente</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>&nbsp;</strong></td>
                </tr>
                <tr>
                    <td colspal="1" style="height: 60px; width: 50%"></td>
                    <td colspal="1" style="height: 60px; text-align: right; width: 50%; padding-right: 5rem;"><img src="http://bimo-lab.com/pdf/logo/firma.png" alt="" style="width: 15%"></td>
                </tr>
                <tr style="font-size: 13px;">
                    <td colspan="1" style="text-align: center; width: 50%">AQUI VA EL QR</td>
                    <td colspan="1" style="text-align: right; width: 50%"><strong>Q.F.B. NERY FABIOLA ORNELAS RESENDIZ    <br>UPCH - Cédula profesional: 09291445</strong></td>
                </tr>
            </table>
            <hr style="height: 2px; background-color: black ;">
            <p style="text-align: center;"><small><strong>Avenidad Universidad S/N Colonia Casa Blanca, Villahermosa, Tabasco - Teléfono: 993 131 00 42 Correo electrónico: biologia.molecular@hguadalupe.com</strong></small></p>
        </footer> -->
    </div>
    
</body>
</html>