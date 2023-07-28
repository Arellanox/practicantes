<style>
    #table_antigeno th {
        background-color: gray;
        padding: 10px 7px 10px 7px;
        /* text-justify: left; */
        text-align: left;
        font-size: 16px;
    }

    #table_antigeno td,
    #table_antigeno strong {
        padding: 10px 7px 10px 6px;
        font-size: 16px;
        text-align: left;
    }

    #table_antigeno {
        margin-top: 80px;
    }

    #informacion p,
    #informacion strong {
        font-size: 15px;
    }

    /* #table_antigeno tr.header th {} */

    /* #table_antigeno .col-rigth {
        text-justify: left;
    }

    #table_antigeno .col-center {
        text-justify: left;
    } */
</style>


<p style="position:absolute;top:2px;left:548px;white-space:nowrap font-size: 12px !important" class="ft00">Muestra: <strong style="font-size: 11px"><?php echo $body[1]->resultado ?></strong> </p>

<br>
<hr style="text-align: center; border-style: solid none solid none;width:100%">

<table id="table_antigeno" cellspacing="0">
    <!-- <tr>
        <th colspan="3">Encabezado de la tabla</th>
    </tr> -->
    <tr class="header">
        <th>Prueba</th>
        <th>Resultado</th>
        <th>Valor de normalidad</th>
    </tr>
    <tr>
        <td><strong>Antígeno ANTI-SARS-CoV-2</strong> </td>
        <td><?php echo $body[0]->resultado ?></td>
        <td><strong>NEGATIVO</strong> </td>
    </tr>

</table>

<div id="informacion"></div>

<br>
<br><br><br><br>
<p>Lote de kit: <strong><?php echo $body[3]->resultado ?></strong> </p>
<p>Comentarios: Esta prueba identifica la presencia de antígeno del Coronavirus SARS-CoV-2,
    el resultado negativo de la prueba no significa inmunidad y el médico tratante es quien
    realiza la interpretación de este resultado de acuerdo a los datos clínicos que el
    paciente presente.
    <br>
    Kit utilizado: <strong><?php echo $body[4]->resultado ?></strong>
</p>
<br>
<p>
    <a href="https://www.gob.mx/cms/uploads/attachment/file/730956/Listado_de_pruebas_de_ant_geno__tiles_para_SARS-CoV-2__Puntos_de_Atenci_n_.pdf">https://www.gob.mx/cms/uploads/attachment/file/730956/Listado_de_pruebas_de_ant_geno__tiles_para_SARS-CoV-2__Puntos_de_Atenci_n_.pdf</a>
</p>
</div>