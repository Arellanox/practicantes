<br>
<br>
<br>
<br>
<p style="position:absolute;top:2px;left:548px;white-space:nowrap" class="ft00">Muestra: <strong style="font-size: 11px"><?php echo $body[7]->resultado ?></strong> </p>
<table style="width: 100%; font-size: 13.4px">
    <tr style="background-color: darkgrey; padding-bottom: 7px; padding-top: 7px;">
        <td><strong style="font-size: 13.4px">Prueba</strong></td>
        <td><strong style="font-size: 13.4px">Resultado</strong></td>
        <td><strong style="font-size: 13.4px">Valor de Normalidad</strong></td>
    </tr>
    <tr>
        <td><strong style="font-size: 13.4px">rT-PCR-VPH-AR (24 tipos) </strong></td>
        <td><strong style="font-size: 13.4px"></strong></td>
        <td><strong style="font-size: 13.4px"></strong></td>
    </tr>
    <tr>
        <td>Detección de VPH Genotipo 16</td>
        <td> <?php echo $body[0]->resultado; ?> </td>
        <td>NEGATIVO</td>
    </tr>
    <tr>
        <td>Detección de VPH Genotipo 18</td>
        <td><?php echo $body[1]->resultado; ?></td>
        <td>NEGATIVO</td>
    </tr>
    <tr>
        <td>Detección de VPH Genotipo 45</td>
        <td><?php echo $body[2]->resultado; ?>
        </td>
        <td>NEGATIVO</td>
    </tr>
    <tr>
        <td>Detección de Otros tipos de VPH de Alto Riesgo: <br>
            26, 30, 31, 33, 34, 35, 39, 51, 52, 53, 56, 58, 59, 66,<br> 67, 68, 69, 73, 82, 97, y otros de bajo riesgo: 70
        </td>
        <td><?php echo $body[3]->resultado; ?></td>
        <td>NEGATIVO</td>
    </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<p style="text-align:justify;font-size: 13.4px"><small></small><strong>Comentarios: </strong>Esta prueba identifica en tiempo real la presencia de 24 tipos de virus del papiloma humano (23 VPH-AR y 1 VPH-BR) de alto riesgo, incluyendo la tipificación de VPH 16, 18 Y 45, en el caso de la detección de otros tipos de VPH de alto riesgo y uno o mas de los tipificados es posible se trate de una coinfección; el médico tratante es quien realiza la interpretación de este resultado considerando los datos clínicos del paciente.</small></p>

<p style="text-align:justify;font-size: 13.4px"><strong>Equipo utilizado: </strong>CFX96™ Real-Time System BIO-RAD<br>
    <strong>Kit Diagnóstico: </strong><?php echo $body[4]->resultado; ?> - Autorización COFEPRIS: <?php echo $body[6]->resultado; ?> <br>
    <strong>No. lote: </strong> <?php echo $body[5]->resultado; ?>
</p>

<p class="text-sm-start" style="font-size: 13.4px"><small><strong>Encuentre el oficio de autorización InDre del kit diagnóstico usado para su estudio en:</strong></small></p>
<p style="text-align: center;font-size: 13.4px"><small><a href="https://www.gob.mx/cms/uploads/attachment/file/574964/Registros_Sanitarios_DM2019.pdf">https://www.gob.mx/cms/uploads/attachment/file/574964/Registros_Sanitarios_DM2019.pdf</a></small></p>
<!--<p class="text-sm-start"><small><strong>Consulte el aviso de cierre de proceso de reconocimiento a la evaluación comparativa a los laboratorios clínicos privados en:</strong></small></p>
        <p style="text-align: center;"><small><a href="#">https://www.gob.mx/cms/uploads/attachment/file/546877/Cierre_Reconocimiento_a_la_evaluaci_n_comparativa_a_laboratorios_<br>cl_nicos_privados.pdf</a></small></p>
        -->