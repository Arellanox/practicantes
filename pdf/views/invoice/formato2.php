<?php
/* $folio = $_POST['folio']; */
?>

<!DOCTYPE html>
<html>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">  -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

<body>

    <div id="elemento-a-exportar">

        <head>
            <style>
                body {
                    font-family: 'Roboto', sans-serif;

                }

                /* Content */
                .invoice-content {
                    border-radius: 4px;
                    padding-bottom: 10px;
                    padding-right: 30px;
                    padding-left: 30px;
                    text-align: justify;
                    text-justify: inter-word;
                }


                h1 {
                    font-size: 22px;
                    margin-top: 2px;
                    margin-bottom: 2px;
                }

                h2 {
                    font-size: 15px;
                    margin-top: 18px;
                    /* margin-bottom: 10px; */
                    text-align: center;
                    background-color: rgba(215, 222, 228, 0.748);
                    /* padding-top: 10px; */
                }

                h3 {
                    font-size: 16px;
                    margin-top: 2px;
                    margin-bottom: 2px;
                }

                h4 {
                    font-size: 14px;
                    margin-top: 2px;
                    margin-bottom: 2px;
                }

                h5 {
                    color: rgb(000, 078, 089);
                    font-size: 12.5px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                }

                h6 {
                    color: rgb(000, 078, 089);
                    font-size: 10.5px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                }

                .h6 {
                    color: rgb(000, 078, 089);
                    font-size: 10.5px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                }

                .h7 {
                    color: rgb(000, 078, 089);
                    font-size: 8.5px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                }

                .h8 {
                    color: rgb(000, 078, 089);
                    font-size: 6.5px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                }

                p {
                    font-size: 12px;
                }

                strong {
                    font-size: 12px;
                }

                .align-center {
                    text-align: center;
                }

                table {
                    width: 100%;
                    max-width: 100%;
                    margin: auto;
                    white-space: nowrap;
                    /* table-layout:fixed; */
                }

                th,
                td {
                    width: 100%;
                    max-width: 100%;
                    word-break: break-all;
                }


                /* Para divisiones de 3 encabezado*/
                .col-left {
                    width: 35%;
                    max-width: 35%;
                    text-align: left;
                    font-size: 12px;
                }

                .col-center {
                    width: 35%;
                    max-width: 35%;
                    text-align: left;
                    font-size: 12px;
                }

                .col-right {
                    width: 30%;
                    max-width: 30%;
                    text-align: left;
                    font-size: 12px;
                }

                /* divisiones de 3 footer */
                .col-foot-one {
                    width: 30%;
                    max-width: 30%;
                    text-align: left;
                    font-size: 12px;
                }

                .col-foot-two {
                    width: 40%;
                    max-width: 40%;
                    text-align: center;
                    font-size: 12px;
                }

                .col-foot-three {
                    width: 30%;
                    max-width: 30%;
                    text-align: right;
                    font-size: 12px;
                }

                /* Para divisiones de 4 */
                .result {
                    font-size: 12px
                }

                /* diviciones de 2 */
                .col-izq {
                    width: 30%;
                    max-width: 30%;
                    text-align: left;
                }

                .col-der {
                    width: 70%;
                    max-width: 70%;
                    text-align: center;
                }

                /* Fivisiones de cinco */
                .col-one {
                    width: 30%;
                    max-width: 30%;
                    text-align: left;
                }

                .col-two {
                    width: 20%;
                    max-width: 20%;
                    text-align: right;
                }

                .col-three {
                    width: 25%;
                    max-width: 25%;
                    text-align: center;

                }

                .col-four {
                    width: 25%;
                    max-width: 25%;
                    text-align: center;
                }

                #body {
                    /*    background-color: aqua; */
                    position: fixed;
                    top: -40px;
                    left: -40px;
                    right: -40px;
                    /* bottom: 40px; */
                    height: 111%;
                }

                .col-6 {
                    flex: 1 0 0%;
                    width: 50%;
                    max-width: 50%;
                    text-align: center;
                    position: relative;
                    min-height: 1px;
                    padding-right: 15px;
                    padding-left: 15px;
                }

                .row {
                    display: flex !important;
                    justify-content: center;
                    flex-wrap: wrap;
                }

                .row>col {
                    width: 100%;
                    max-width: 100%;
                    padding-right: calc(var(--bs-gutter-x) * .5);
                    padding-left: calc(var(--bs-gutter-x) * .5);
                    margin-top: var(--bs-gutter-y);
                }

                .border {
                    border: 1px solid black;
                    padding: 0px !important;
                }

                .border-bottom {
                    border-bottom: 1px solid black;
                }

                .border-top {
                    border-top: 1px solid black;
                }

                .border-left {
                    border-left: 1px solid black;
                }

                .border-right {
                    border-right: 1px solid black;
                }

                .bg-title {
                    background-color: #d8dfe1 !important;
                }

                .p-0 {
                    padding: 0px !important;
                }

                .m-0 {
                    margin: 0px !important;
                }

                /* Margin    */
                .mx-1 {
                    margin-left: 0.25rem;
                    margin-right: 0.25rem;
                }

                .mx-2 {
                    margin-left: 0.5rem;
                    margin-right: 0.5rem;
                }

                .mx-3 {
                    margin-left: 1rem;
                    margin-right: 1rem;
                }

                .mx-4 {
                    margin-left: 1.5rem;
                    margin-right: 1.5rem;
                }

                .mx-5 {
                    margin-left: 3rem;
                    margin-right: 3rem;
                }

                .mx-6 {
                    margin-left: 4rem;
                    margin-right: 4rem;
                }

                .mx-7 {
                    margin-left: 5rem;
                    margin-right: 5rem;
                }

                .mb-1 {
                    margin-bottom: 0.25rem;
                }

                .mb-2 {
                    margin-bottom: 0.5rem;
                }

                .mb-3 {
                    margin-bottom: 1rem;
                }

                .mb-4 {
                    margin-bottom: 1.5rem;
                }

                .mb-5 {
                    margin-bottom: 3rem;
                }

                .mb-6 {
                    margin-bottom: 4rem;
                }

                .mb-7 {
                    margin-bottom: 5rem;
                }

                .mt-1 {
                    margin-top: 0.25rem;
                }

                .mt-2 {
                    margin-top: 0.5rem;
                }

                .mt-3 {
                    margin-top: 1rem;
                }

                .mt-4 {
                    margin-top: 1.5rem;
                }

                .mt-5 {
                    margin-top: 3rem;
                }

                .mt-6 {
                    margin-top: 4rem;
                }

                .mb-7 {
                    margin-bottom: 5rem;
                }

                /* Padding */


                .px-1 {
                    padding-left: 0.25rem;
                    padding-right: 0.25rem;
                }

                .px-2 {
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                }

                .px-3 {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                .px-4 {
                    padding-left: 1.5rem;
                    padding-right: 1.5rem;
                }

                .px-5 {
                    padding-left: 3rem;
                    padding-right: 3rem;
                }

                .px-6 {
                    padding-left: 4rem;
                    padding-right: 4rem;
                }

                .px-7 {
                    padding-left: 5rem;
                    padding-right: 5rem;
                }

                .pb-1 {
                    padding-bottom: 0.25rem;
                }

                .pb-2 {
                    padding-bottom: 0.5rem;
                }

                .pb-3 {
                    padding-bottom: 1rem;
                }

                .pb-4 {
                    padding-bottom: 1.5rem;
                }

                .pb-5 {
                    padding-bottom: 3rem;
                }

                .pb-6 {
                    padding-bottom: 4rem;
                }

                .pb-7 {
                    padding-bottom: 5rem;
                }

                .pt-1 {
                    padding-top: 0.25rem;
                }

                .pt-2 {
                    padding-top: 0.5rem;
                }

                .pt-3 {
                    padding-top: 1rem;
                }

                .pt-4 {
                    padding-top: 1.5rem;
                }

                .pt-5 {
                    padding-top: 3rem;
                }

                .pt-6 {
                    padding-top: 4rem;
                }

                .pb-7 {
                    padding-bottom: 5rem;
                }

                /* Displays */

                .d-flex {
                    display: flex !important;
                }

                .fw-bold {
                    font-weight: bold !important;
                }

                /* Tabla de equipos y termometros edit */

                #equipos td,
                #equipos tr {
                    line-height: 0.8 !important;
                    /* Establece el valor adecuado para reducir el espacio vertical */
                }

                .line-height {
                    line-height: 0.8 !important;
                }

                #equipos tbody {
                    line-height: 0.8 !important;
                    margin: 0px;
                    padding: 0px;
                }

                #equipos {
                    line-height: 0.8 !important;
                    margin: 0px;
                    padding: 0px;
                }

                .folio {
                    color: rgb(000, 078, 089);
                    font-size: 10.5px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                }


                /* Estilos de la tabla de puntos */

                #grafica {}

                #grafica table {
                    width: 10px !important;
                    border-collapse: collapse;
                }

                #grafica th,
                #grafica td {
                    border: 1px solid black;
                }

                #grafica td.empty {
                    /* margin-left: auto; */
                    /* margin-right: auto; */
                    padding: 0px;
                    width: 8px;
                    /* min-width: 14px; */
                    /* max-width: 14px; */
                    /* max-height: 14px; */
                    /* min-height: 14px; */
                }

                .turno-1 {
                    border: 0.8px dashed black !important;
                }

                .turno-2 {
                    border: 0.8px dashed black !important;
                }

                .turno-3 {
                    border-left: 0.8px dashed black !important;
                    border-top: 0.8px dashed black !important;
                    border-bottom: 0.8px dashed black !important;
                }

                .celdasDias {
                    color: rgb(000, 078, 089);
                    font-size: 8.5px;
                    width: 8px !important;
                    font-weight: normal !important;
                    border-left: none !important;
                    border-top: 5px solid #0000 !important;
                    border-bottom: none !important;
                }

                .diaHeader {
                    color: rgb(000, 078, 089);
                    font-size: 8.5px;
                    padding: 2px !important;
                    background-color: #d8dfe1 !important;
                }

                .text-rango {
                    /* font-size: 5px !important; */
                    font-weight: bold !important;
                    /* padding-top: 5px; */
                    /* padding-bottom: 5px; */
                }

                .bg-grey {
                    background-color: #d8dfe1;

                }

                .dot {
                    /* max-height: 20px;
                              max-width: 10px; */
                    /* font-size: 20px;
                              text-align: center !important; */
                    /* font-size: 38px;
                              text-align: center !important;
                              /* padding: 0px; */
                    /* margin: 0px; 
                              height: 0px;
                              */

                    /* padding-left: 9px;
                              padding-bottom: 11px; */

                }

                .dot-div::before {
                    content: '';
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    border-radius: 7.5px;
                    z-index: 100;
                    position: absolute;
                    /* background-color: #69b6d5; */
                }

                .dot-div {
                    /* background-color: blue; */
                    position: relative;
                    /* top: 10px; */
                    left: 8.7px;
                    min-height: 0px;
                    max-height: 0px;
                    cursor: pointer;
                }

                .dot-blue::before {
                    background-color: blue;
                }

                .dot-mostaza::before {
                    background-color: #ffa209;
                }

                .dot-div:hover {
                    background-color: rgb(0 175 170 / 60%)
                }


                /* .dot-div::after {
                              background-color: #ffa209;
                              border-radius: 50%;
                          } */





                .border-bottomm {
                    border-bottom: 1.5px solid !important;
                }
            </style>


        </head>
        <?php

        // para el path del logo 
        $ruta = file_get_contents('../pdf/public/assets/icono_reporte_checkup.png');
        $encode = base64_encode($ruta);

        // Para la firma se requiere mandar la "firma" tambien en base 64 e incrustarlo como en el ejemplo de arriba,
        //los datos de abajo son meramente informativos y solo sirven para rellenar la informacion del documento
        // echo '<img src="data:image/png;base64, '. $img_valido .'" alt="" height="75" >';

        // path firma
        $ruta_firma = file_get_contents('../pdf/public/assets/firma_quiroz.png'); //FIRMA_URL
        $encode_firma = base64_encode($ruta_firma);

        ?>

        <div id="body">
            <!-- header -->
            <div class="header mt-3">
                <table>
                    <tbody>
                        <tr>
                            <td class="col-foot-one"></td>
                            <td class="col-foot-two" style="border-bottom: none">
                                <h5>
                                    DIAGNOSTICO BIOMOLECULAR S.A.de C.V. <br>
                                    (ÁREA)
                                </h5>

                                <h6>
                                    FORMATO PARA EL REGISTRO DE TEMPERATURAS DE EQUÍPOS <br>
                                    FUG-08-DB
                                </h6>
                            </td>
                            <td class="col-foot-three" style="border-bottom: none; text-align:center;">
                                <?php
                                echo "<img src='data:image/png;base64, " . $encode . "' height='45' >";
                                // echo "<img src='data:image/png;base64," . $barcode . "' height='75'>";
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabla de equipos y Termometro -->
            <div class="body  mx-7">
                <table id="equipos" class="p-0 m-0">
                    <tbody class="m-0 p-0">
                        <tr class="line-height p-0 m-0">
                            <td class="line-height col-foot-der"></td>
                            <td class="line-height col-foot-izq d-flex p-0 m-0">
                                <table class="p-0 m-0">
                                    <tbody class="p-0  m-0">
                                        <tr class="line-height p-0 m-0">
                                            <td class="line-height p-0 m-0 col-foot-der">
                                                <div class="p-0 m-0 bg-title" style="background-color:#fff !important;">
                                                    <h6 class=" m-0 p-0">Folio:</h6>
                                                </div>
                                            </td>
                                            <td class="p-0 m-0 line-height col-foot-izq d-flex">
                                                <input class="border p-0 m-0 folio" type="text" value="N/A" style="max-width:100px;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table id="equipos" class="p-0 m-0">
                    <tbody class="p-0 m-0">
                        <tr>
                            <td class="col-foot-der" style="border-bottom: none">
                                <!-- Tabla Equipos -->
                                <div class="tabla-equipos">
                                    <table class="">
                                        <thead class="border-top border-left border-right ">
                                            <tr class="p-0 m-0">
                                                <th colspan="3" class="bg-title">
                                                    <h6 class=" m-0 p-0">EQUIPO</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="border">
                                            <tr class="">
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Equipo:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold"> Congelador</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Modelo:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold">&&&&&&&&</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Localización:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold">&&&&&&&&</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Marca:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold"> Congelador</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7">N° Serie:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold">&&&&&&&&</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7">Intervalo Optimo:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold"> -25 A -35°C </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </td>
                            <div class="mx-2"></div>
                            <td class="col-foot-izq" style="border-bottom: none; text-align:center;">
                                <!-- Tabla termometros -->
                                <div class="tabla-termometros">
                                    <table class="">
                                        <thead class="border-top border-left border-right ">
                                            <tr class="p-0 m-0">
                                                <th colspan="3" class="bg-title">
                                                    <h6 class=" m-0 p-0">TERMOMETRO</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="border">
                                            <tr class="">
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Equipos:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold"> Congelador</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Modelo:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold">&&&&&&&&</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Localización:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold">&&&&&&&&</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7"> Marca:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold"> Congelador</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7">N° Serie:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold">&&&&&&&&</label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <div class="d-flex">
                                                        <label class="h7">Intervalo Optimo:</label>
                                                        <label class="h7 border-bottom px-3 fw-bold"> -25 A -35°C </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabla de puntos -->
            <div id="grafica">
                <table>
                    <tr>
                        <th class="celdasDias"></th>
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo "<th class='diaHeader' colspan='3'>" . $i . "</th>";
                        }
                        ?>
                    </tr>


                    <?php
                    function objectToArray($obj)
                    {
                        if (is_object($obj)) {
                            $obj = (array) $obj;
                        }

                        if (is_array($obj)) {
                            $new = array();
                            foreach ($obj as $key => $val) {
                                $new[$key] = objectToArray($val);
                            }
                        } else {
                            $new = $obj;
                        }

                        return $new;
                    }

                    $arrayRespuesta = objectToArray($resultados);

                    $max = $arrayRespuesta['EQUIPO']['INTERVALO_MAX'];
                    $min = $arrayRespuesta['EQUIPO']['INTERVALO_MIN'];
                    $data = arrayDia(-20, $max + 5, $min - 5);


                    $valores = $arrayRespuesta['DIAS'];

                    $dotInicial =  array_key_first($valores);
                    $dotEnd =  array_key_last($valores);

                    function redondear($valor, $valorAprox, $max, $min)
                    {

                        $explode = explode('.', $valor);

                        // $signo = $explode[0] > 0 ? '' : '-';
                        // $unidad = $explode[0] > 0 ? $explode[0]  : ($explode[0] * -1);
                        // $decimal = $explode[1] > 50 ? 1 : 0;

                        // $valor_final = ($unidad + ($decimal));


                        //10px - 40px
                        //100% = 30px
                        //0.34
                        //30*0.34 = ?
                        //

                        if ($valor >= $max) {
                            $pixeles = 10;
                            $explode[0] = $max;
                        }

                        if ($valor <= $min) {
                            $pixeles = 10;
                            $explode[0] = $min;
                        }


                        if ($valor > 0) {
                            if ($explode[1] > 0) {

                                $pixeles = (($explode[1] / 100) * 30) + 10;

                                $pixeles = (($pixeles) - ($pixeles * 0.8)) * -1;
                            }
                        } else {
                            $pixeles = (($explode[1] / 100) * 30) + 10;
                        }




                        # 3 / 100 =0.03
                        # 0.03 * 30 = 0.9
                        # 0.9 + 1- = 10.9


                        // $pixeles = $valor > 0 ? ($pixeles * -1) + ($pixeles * 0.8) : $pixeles;



                        return [$explode[0], $pixeles . "px"];


                        // return $explode[0];
                    }


                    function arrayDia($num, $max, $min)
                    {

                        // for ($j = $max + 5; $j >= $min - 5; $j--) {
                        //     $data += $j;
                        // }
                        if (in_array($num, range($max, $min))) {
                            return true;
                        }
                        return false;
                    }




                    function metodoCalculo($dia, $turno, $valorAprox, $valor, $max, $min, $valores)
                    {

                        if ($valores) {
                            echo ("asdsadsadsadsadsa");
                            // $valor = floatval($valores[$dia][$turno]["valor"]);
                            // $valor_redondeado = round($valor);
                            $valor = $valores[$dia][$turno]["valor"];
                            $valor_turno = redondear($valores[$dia][$turno]["valor"], $valorAprox, $max + 5, $min - 5);
                            $valor_redondeado = $valor_turno[0];
                            $valor_decimal_px = $valor_turno[1];

                            $color = $valores[$dia][$turno]['color'];
                            $id = $valores[$dia][$turno]['id'];
                            if ($valor_redondeado == $valorAprox) {
                                $dotId = "dot-$dia-$turno"; // Generar el ID del dot

                                if (arrayDia($valorAprox, $max - 1, $min)) {
                                    return "<td class='td-hover bg-grey empty turno-$turno'  data_id='$id'><div id='$dotId' class='dot dot-div dot-$color' style='top:$valor_decimal_px' data-bs-toggle='tooltip' data-bs-placement='top' title='$valor °C'>
                                    
                                    
                                    </div></td>";
                                } else {
                                    return "<td class='td-hover empty turno-$turno'  data_id='$id'><div id='$dotId' class='dot dot-div dot-$color' style='top:$valor_decimal_px' data-bs-toggle='tooltip' data-bs-placement='top' title='$valor °C'></div></td>";
                                }
                            }
                        }

                        if (arrayDia($valorAprox, $max - 1, $min)) {
                            return "<td class='bg-grey empty turno-$turno'></td>";
                        } else {
                            return "<td class='empty turno-$turno background$valorAprox'></td>";
                        }
                    }

                    // Generar las celdas de la tabla
                    for ($j = $max + 5; $j >= $min - 5; $j--) {
                        if ($j == $max) {
                            echo "<tr class='border-bottomm'>";
                        } else if ($j == $min) {
                            echo "<tr class='border-bottomm'>";
                        } else {
                            echo "<tr class='border$j'>";
                        }


                        if ($j == $max) {
                            echo "<th class='celdasDias text-rango'>" . $j . "</th>";
                        } else if ($j == $min) {
                            echo "<th class='celdasDias text-rango'>" . $j . "</th>";
                        } else {
                            echo "<th class='celdasDias text$j'>" . $j . "</th>";
                        }

                        $prevDot = null; // Dot previo para conectar con líneas

                        for ($i = 1; $i <= 31; $i++) {
                            echo metodoCalculo($i, 1, $j, $valor, $max, $min, $valores);
                            echo metodoCalculo($i, 2, $j, $valor, $max, $min, $valores);
                            echo metodoCalculo($i, 3, $j, $valor, $max, $min, $valores);
                            /* $dot3 = metodoCalculo($i, 3, $j); */

                            // if ($dot1 != '<td class="empty turno-1 background' . $j . '"></td>') {
                            //     echo $dot1;
                            //     if ($dot2 != '<td class="empty turno-2 background' . $j . '"></td>') {
                            //         echo $dot2;
                            //         if ($dot3 != '<td class="empty turno-3 background' . $j . '"></td>') {
                            //             echo $dot3;
                            //         } else {
                            //             $prevDot = null; // No hay dot en el turno 2, reiniciar dot previo
                            //         }
                            //     } else {
                            //         $prevDot = null; // No hay dot en el turno 2, reiniciar dot previo
                            //     }
                            // } else {
                            //     $prevDot = null; // No hay dot en el turno 1, reiniciar dot previo
                            // }
                        }
                        echo "</tr>";
                    }

                    echo "<tr class='border$j'>";
                    echo "<th class='celdasDias text$j'>" . $j . "</th>";
                    for ($i = 1; $i <= 31; $i++) {
                        echo "<td class='empty turno-1 background'></td>";
                        echo "<td class='empty turno-2 background'></td>";
                        echo "<td class='empty turno-3 background'></td>";
                    }
                    echo "</tr>";

                    ?>
                </table>
            </div>


        </div>

    </div>
<br><br><br><br>
    <?php
    print_r($resultados);
    ?>


    <?php

    echo "<pre>";

    var_dump($data);
    echo "</pre>";
    ?>
</body>


</html>