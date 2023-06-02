<br>
<br>
<br>
<br>
<p style="position:absolute;top:2px;left:548px;white-space:nowrap" class="ft00">Muestra: <strong style="font-size: 11px"><?php echo $body[7]->resultado ?></strong> </p>
<table style="width: 100%;">
    <tr style="background-color: darkgrey;">
        <td><strong>Prueba</strong></td>
        <td><strong>Resultado</strong></td>
        <td><strong>Valor de Normalidad</strong></td>
    </tr>
    <tr>
        <td><strong>rT-PCR-SARS-CoV2 (Coronavirus)</strong></td>
        <td>
            <strong>
                <?php if ($body[0]->resultados === "POSITIVO" || $body[1]->resultado === "POSITIVO" || $body[2]->resultado === "POSITIVO") {
                    echo 'POSITIVO';
                } else {
                    echo 'NEGATIVO';
                } ?>
            </strong>
        </td>
        <td><strong>Negativo</strong></td>
    </tr>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td><strong>Valor CT N1: </strong> <?php echo $body[0]->resultado; ?></td>
        <td><strong>N2: </strong> <?php echo $body[1]->resultado; ?></td>
        <td><strong>N3: </strong> <?php echo $body[2]->resultado; ?></td>
    </tr>
</table>
<br>
<br>
<br>
<br>
<p style="text-align:justify;"><strong>Comentarios: </strong>Esta prueba identifica en tiempo real la presencia del Coronavirus SARS-CoV-2, el resultado
    negativo de la prueba no significa inmunidad y el médico tratante es quien realiza la interpretación de este resultado de acuerdo a los datos
    clínicos que el paciente presente.</p>
<br>
<p style="text-align:justify;"><strong>Equipo utilizado: </strong> CFX96™ Real-Time System BIO-RAD <br>
    <strong>Kit Diagnóstico: </strong><?php echo $body[4]->resultado; ?> - Autorización InDre: <?php echo $body[5]->resultado; ?><br>
    <strong>No. lote: </strong> <?php echo $body[6]->resultado; ?>
</p>
<br>

<p class="text-sm-start"><small><strong>Encuentre el oficio de autorización InDre del kit diagnóstico usado para su estudio en:</strong></small></p>
<p style="text-align: center;"><small><a href="https://www.gob.mx/cms/uploads/attachment/file/785143/Listado_de_pruebas_moleculares_por_RT-PCR_Multiplexado_evaluadas_para_el_diagn_stico_de_SARS-CoV-2.pdf">https://www.gob.mx/cms/uploads/attachment/file/785143/Listado_de_pruebas_moleculares_por_RT-PCR_Multiplexado_evaluadas_para_el_diagn_stico_de_SARS-CoV-2.pdf</a></small></p>
<p class="text-sm-start"><small><strong>Consulte el aviso de cierre de proceso de reconocimiento a la evaluación comparativa a los laboratorios clínicos privados en:</strong></small></p>
<p style="text-align: center;"><small><a href="#">https://www.gob.mx/cms/uploads/attachment/file/546877/Cierre_Reconocimiento_a_la_evaluaci_n_comparativa_a_laboratorios_<br>cl_nicos_privados.pdf</a></small></p>
<br>