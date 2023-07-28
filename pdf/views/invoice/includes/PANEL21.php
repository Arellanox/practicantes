<style>
    .bold {
        font-weight: bold;
    }

    .cursive {
        font-style: italic;
    }

    .rojo {
        color: red;
    }

    .resultados_resp td {
        width: 33.3%;
    }
</style>


<?php

$lote = $body[count($body) - 1];
$muestra = $body[count($body) - 2];
$autorizacion = $body[count($body) - 3];
$kit = $body[count($body) - 4];

?>

<!-- <p style="background-color: darkgrey; padding: 5px;text-align: center;"><strong>INFORMACIÓN CLÍNICA</strong></p> -->
<br>
<p style="position:absolute;top:2px;left:548px;white-space:nowrap" class="ft00">Muestra: <strong style="font-size: 11px"><?php echo $body[7]->resultado ?></strong> </p>

<table class="resultados_resp" style="width: 100%; border-collapse: collapse; text-align: center;">
    <tr style="background-color: darkgrey;" class="bold">
        <td style="text-align: left;">Prueba rT-PCR Panel Respiratorio (21)</td>
        <td>Resultado</td>
        <td>Valor de Normalidad</td>
    </tr>

    <?php

    $body = array_slice($body, 1, count($body) - 5);
    foreach ($body as $key => $value) {
        if (isset($value->resultado)) {
    ?>
            <tr>
                <td style="text-align: left;" class="cursive"><?php echo $value->nombre ?></td>
                <td class="<?php echo $value->resultado == 'POSITIVO' ? "bold rojo" : "bold";  ?>"><?php if ($value->resultado != 'N/A') echo $value->resultado ?></td>
                <td><?php if ($value->resultado != 'N/A') echo "NEGATIVO"; ?></td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr class="bold">
                <td colspan="12" style="text-align: left;">•<?php echo $value->nombre ?></td>
            </tr>
    <?php
        }
    }

    ?>

</table>
<p style="text-align: justify"><strong>Comentarios:</strong>La prueba está concebida como una ayuda en el diagnóstico de infecciones de las vías respiratorias causadas por el virus
    de la gripe A (IAV), el virus de la gripe A subtipo H1N1 de linaje porcino (IAV [H1N1] swl), el virus de la gripe B (IBV), el rinovirus humano
    (HRV), los coronavirus humanos (HCoV) 229E, NL63, HKU1 y OC43, los virus paragripales humanos (HPIV) 1 a 4, el metaneumovirus
    humano (HMPV) A y B, el bocavirus humano (HBoV),Mycoplasma pneumoniae (M. pneumoniae), los virus respiratorios sincitiales
    humanos (HRSV) A y B, el parecovirus humano (HPeV), el enterovirus (EV) y el adenovirus humano (HAdV).y el médico tratante es quien
    realiza la interpretación de este resultado de acuerdo a los datos clínicos que el paciente presente.
</p>
<table style="width: 100%;">
    <tr>
        <td colspan="6" style="width: 15% ;"><strong>Equipo Utilizado:</strong> CFX96™ Real-Time System BIO-RAD </td>
        <td colspan="6" style="width: 0% ;"><strong>No. Lote:</strong> <?php echo $lote->resultado; ?> </td>
    </tr>
    <tr>
        <td colspan="6" style="width: 15% ;"><strong>Kit Diagnóstico:</strong> <?php echo $kit->resultado ?> </td>
        <td colspan="6" style="width: 0% ;"><strong>Registro Sanitario:</strong> <?php echo $autorizacion->resultado ?> </td>
    </tr>
</table>