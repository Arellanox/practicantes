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

                /* Widt */

                .w-50 {
                    width: 50% !important;
                }

                .w-100 {
                    width: 100% !important;
                }

                .w-25 {
                    width: 25% !important;
                }

                /* Height */

                .h-50 {
                    height: 50% !important;
                }

                .h-100 {
                    height: 100% !important;
                }

                .h-25 {
                    height: 25% !important;
                }


                /* Tabla de equipos y termometros edit */

                #equipos td,
                #equipos tr {
                    height: 0px;
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
                    border-top: 1px solid black;
                    border-left: 1px solid black;
                    border-right: 1px solid black;
                    border-bottom: 1px solid black !important;
                    /* padding: 1px !important; */
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

        function convertirObjetoAArray($objeto)
        {
            if (is_object($objeto)) {
                $objeto = (array)$objeto;
            }
            if (is_array($objeto)) {
                return array_map('convertirObjetoAArray', $objeto);
            }
            return $objeto;
        }

        $array = convertirObjetoAArray($resultados);
        $valores = $array['DIAS'];

        // echo "<pre>";
        // var_dump($valores);
        // // var_dump($valores[1][1]['valores']);
        // // $num = 20;
        // // var_dump($valores[$num] !== null ? "si existe" : "no existe");
        // echo "</pre>";
        // exit;

        // para el path del logo 
        $ruta = file_get_contents('../pdf/public/assets/icono_reporte_checkup.png');
        $encode = base64_encode($ruta);

        // Para la firma se requiere mandar la "firma" tambien en base 64 e incrustarlo como en el ejemplo de arriba,
        //los datos de abajo son meramente informativos y solo sirven para rellenar la informacion del documento
        // echo '<img src="data:image/png;base64, '. $img_valido .'" alt="" height="75" >';

        // path firma
        $ruta_firma = file_get_contents('../pdf/public/assets/firma_quiroz.png'); //FIRMA_URL
        $encode_firma = base64_encode($ruta_firma);

        $captura_tabla = file_get_contents('../pdf/public/assets/temperaturas/544/tabla.png'); //TABLA_URL
        $encode_tabla = base64_encode($captura_tabla);

        $captura_canva = file_get_contents('../pdf/public/assets/temperaturas/544/canva.png'); //CANVA_URL
        $encode_canva = base64_encode($captura_canva);

        $captura_dot = file_get_contents('../pdf/public/assets/temperaturas/544/dot.png'); //DOT    _URL
        $encode_dot = base64_encode($captura_dot);

        $Tabla_puntos = file_get_contents($array['EQUIPO']['URL_TABLA']);
        $encode_tabla = base64_encode($Tabla_puntos);

        // Rubrica del supervisor
        $rubrica_supervisor = file_get_contents($array['USUARIO']['RUBRICA']);
        $encode_rubrica_supervisor = base64_encode($rubrica_supervisor);


        function metodoCalculo($dia, $turno, $valor, $valores, $type)
        {

            if ($valores[$dia][$turno] !== null) {
                // $valor = floatval($valores[$dia][$turno]["valor"]);
                // $valor_redondeado = round($valor);
                $valor = $valores[$dia][$turno]["valor"];
                $hora = $valores[$dia][$turno]["hora"];
                $horaMinutos = substr($hora, 0, 5);
                // $hora_parseada = date("h:i a", strtotime($hora));
                // $hora_parseada = strtolower($hora_parseada);

                $ruta_rubrica = $valores[$dia][$turno]["FIRMA"];
                $rubrica = file_get_contents($ruta_rubrica);
                $encode_rubrica = base64_encode($rubrica);

                if ($type == 1) {
                    return "<td class=''>
                    <p class='h8 m-0 p-0' style='text-align:center;'>
                    $valor
                    </p>
                    </td>";
                } else if ($type == 2) {
                    return "<td class='' style='text-align:center;'>
                    <img src='data:image/png;base64," . $encode_rubrica . "' height='25'  style='display:flex; justify-content:center; object-fit:cover; max-height:23px;'>
                    </td>";
                } else {
                    return "<td class=''>
                    <p class='h8 m-0 p-0' style='text-align:center;'>
                    $horaMinutos
                    </p>
                    </td>";
                }
            }

            return "<td class=''></td>";
        }
        ?>

        <div id="body">
            <!-- ================================================================================================ -->

            <!-- header -->
            <div class="header  ">
                <table>
                    <tbody>
                        <tr>
                            <td class="col-foot-one"></td>
                            <td class="col-foot-two" style="border-bottom: none">
                                <h6>
                                    DIAGNOSTICO BIOMOLECULAR S.A.de C.V. <br>
                                    (ÁREA)
                                </h6>

                                <h6>
                                    FORMATO PARA EL REGISTRO DE TEMPERATURAS DE EQUÍPOS <br>
                                    FUG-08-DB
                                </h6>
                            </td>
                            <td class="col-foot-three" style="border-bottom: none; text-align:center;">
                                <?php
                                echo "<img src='data:image/png;base64, " . $encode . "' height='35' >";
                                // echo "<img src='data:image/png;base64," . $barcode . "' height='75'>";
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ================================================================================================ -->

            <!-- Tabla de equipos y Termometro -->
            <div class="body  mx-7">
                <table id="equipos" style=" position: relative; bottom:10px;" class="p-0">
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
                                                <input class=" p-0 m-0 folio" type="text" value="<?php echo $array['EQUIPO']['FOLIO']; ?>" style="max-width:100px;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table id="equipos" style="max-width:100px; " class="p-0 m-0">
                    <tbody class="p-0 m-0">
                        <tr>
                            <td class="col-foot-der" style="border-bottom: none">
                                <!-- Tabla Equipos -->
                                <div class="tabla-equipos">
                                    <table class="" style="max-width:10px !important; ">
                                        <thead class="border-top border-left border-right ">
                                            <tr class="p-0 m-0">
                                                <th colspan="3" class="bg-title">
                                                    <h6 class=" m-0 p-0">EQUIPO</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="border">
                                            <tr class="">
                                                <td class="" style='max-width:190px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> Equipo:</label>
                                                        <label class="h8 border-bottom px-3 fw-bold"> <?php echo $array['EQUIPO']['EQUIPO_NOMBRE']; ?> </label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> Modelo:</label>
                                                        <label class="h8 border-bottom px-3 fw-bold"><?php echo $array['EQUIPO']['EQUIPO_MODELO']; ?></label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> Localización:</label>
                                                        <label class="h8 border-bottom px-3 fw-bold">
                                                            <?php echo $array['EQUIPO']['LOCALIZACION']; ?>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> Marca:</label>
                                                        <label class="h8 border-bottom px-3 fw-bold"> <?php echo $array['EQUIPO']['EQUIPO_MARCA']; ?></label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7">N° Serie:</label>
                                                        <label class="h8 border-bottom px-3 fw-bold"><?php echo $array['EQUIPO']['EQUIPO_NUMERO_SERIE']; ?></label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7">Intervalo Optimo:</label>
                                                        <label class="h8 border-bottom px-3 fw-bold"> <?php echo $array['EQUIPO']['INTERVALO_MIN']; ?> A <?php echo $array['EQUIPO']['INTERVALO_MAX']; ?> </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                            <td class="col-foot-izq" style="border-bottom: none; text-align:center;">
                                <!-- Tabla termometros -->
                                <div class="tabla-termometros">
                                    <table class="" style="max-width:10px !important; ">
                                        <thead class="border-top border-left border-right ">
                                            <tr class="p-0 m-0">
                                                <th colspan="3" class="bg-title">
                                                    <h6 class=" m-0 p-0">TERMOMETRO</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="border">
                                            <tr class="">
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> Marca:</label>
                                                        <label class="h8 border-bottom px-4 fw-bold"> <?php echo $array['EQUIPO']['TERMOMETRO_MARCA']; ?> </label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> Factor de corrección:</label>
                                                        <label class="h8 border-bottom px-4 fw-bold"><?php echo $array['EQUIPO']['FACTOR_CORRECCION']; ?> °C</label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> MES:</label>
                                                        <label class="h8 border-bottom px-4 fw-bold"><?php echo $array['EQUIPO']['MES']; ?></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7"> ID </label>
                                                        <label class="h8 border-bottom px-4 fw-bold"><?php echo $array['EQUIPO']['TERMOMETRO_ID']; ?></label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7">Fecha de verificación:</label>
                                                        <label class="h8 border-bottom px-4 fw-bold"><?php echo $array['EQUIPO']['FECHA_VERIFICACION'] ?></label>
                                                    </div>
                                                </td>
                                                <td class="" style='max-width:180px;'>
                                                    <div class="d-flex">
                                                        <label class="h7">AÑO:</label>
                                                        <label class="h8 border-bottom px-4 fw-bold"> <?php echo $array['EQUIPO']['ANHO']; ?> </label>
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
            <!-- Fin de tabla de equipos y termoemtro -->

            <!-- ================================================================================================ -->

            <!-- Tabla de puntos -->
            <div style="width:100%;  text-align: center;">

                <?php
                echo "<img src='data:image/png;base64, " .  $encode_tabla . "' class='grafica-tabla' style='object-fit: cover !important;'>";
                // echo "<img src='data:image/png;base64, " . $encode_dot . "' class='grafica-dot'>";
                // echo "<img src='data:image/png;base64, " . $encode_tabla . "' class='grafica-tabla'>";
                // echo "<img src='data:image/png;base64," . $barcode . "' height='75'>";
                ?>

            </div>
            <style>
                .grafica-canva {
                    height: 350px;
                    width: 850px;
                    position: absolute;
                    bottom: 324px;
                    margin-top: 6px;
                    margin-left: 101px;
                    z-index: 1;

                    /* border: 2px solid black */
                }

                .grafica-tabla {
                    /* min-height: 200px; */
                    max-height: 325px;
                    /* min-height: 40%; */
                    object-fit: cover !important;
                    /* height: 50%; */
                    /* height: 350px; */
                    width: 77%;
                    position: absolute;
                    margin-left: 125px;
                    z-index: 0;
                }

                .grafica-dot {
                    height: 350px;
                    width: 850px;
                    position: absolute;
                    margin-left: 80px;
                    margin-top: -9px;
                    z-index: 2;
                    /* border-right: 2px solid black;
                    border-bottom: 1px dashed black; */
                }
            </style>
            <!-- Fin de la tabla de puntos -->

            <!-- ================================================================================================ -->

            <!-- Tabla de Rubrica -->
            <style>
                #rubrica {
                    position: relative;
                    top: 330px;
                }

                #rubrica table {
                    width: 100px;
                    border-collapse: collapse;

                }


                #rubrica td {
                    border: 1px solid black;
                    padding: 0px;
                    width: 26px;
                    height: 25px;
                }

                #rubrica .celdasDias {
                    color: rgb(000, 078, 089);
                    font-size: 10px;
                    width: 8px !important;
                    font-weight: normal;
                    border-left: none !important;
                    /* border-top: 5px solid #0000 !important; */
                    border-bottom: none !important;
                }

                #rubrica .diaHeader {

                    border: 1px solid black;
                }
            </style>
            <div id="rubrica">
                <table id="Matutino">
                    <thead>
                        <tr>
                            <th class=""></th>
                            <?php
                            for ($p = 1; $p <= 31; $p++) {
                                echo "<th class='diaHeader'>" . $p . "</th>";
                            }
                            ?>
                            <th class=""></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        for ($m = 1; $m < 4; $m++) {
                            echo "<tr class=''>";

                            if ($m == 1) {
                                echo "<th class='celdasDias'>
                                <label class='h7'>
                                LECT 1
                                </label>
                                </th>";
                            } else if ($m == 2) {
                                echo "<th class='celdasDias'>
                                 <label class='h7'>
                                RUBRICA
                                </label>
                                </th>";
                            } else {
                                echo "<th class='celdasDias'>
                                <label class='h7'>
                                HORA
                                </label>
                                </th>";
                            }

                            for ($i = 1; $i <= 31; $i++) {
                                // echo "<td class=''></td>";
                                echo metodoCalculo($i, 1, $valor, $valores, $m);
                            }

                            if ($m == 1) {
                                echo "<th class='celdasDias' style=' font-weight: bold !important;  '>° C</th>";
                            } else {
                                echo "<th class='celdasDias'></th>";
                            }

                            echo "</tr>";
                        }
                        ?>
                    </tbody>

                </table>

                <table class="mt-1" id="Vespertino">
                    <tbody>
                        <?php
                        for ($t = 1; $t < 4; $t++) {
                            echo "<tr class=' ' style='margin-top:10px !important;'>";

                            if ($t == 1) {
                                echo "<th class='celdasDias'>
                                <label class='h7'>
                                LECT 2
                                </label>
                                </th>";
                            } else if ($t == 2) {
                                echo "<th class='celdasDias'>
                                 <label class='h7'>
                                RUBRICA
                                </label>
                                </th>";
                            } else {
                                echo "<th class='celdasDias'>
                                <label class='h7'>
                                HORA
                                </label>
                                </th>";
                            }

                            for ($l = 1; $l <= 31; $l++) {

                                echo metodoCalculo($l, 2, $valor, $valores, $t);
                            }

                            if ($t == 1) {
                                echo "<th class='celdasDias' style=' font-weight: bold !important;  '>° C</th>";
                            } else {
                                echo "<th class='celdasDias'></th>";
                            }

                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Fin de tabla de rubrica -->

            <!-- ================================================================================================ -->

            <!-- Campos del supervisor -->
            <style>
                #supervisor {
                    position: relative;
                    top: 335px;
                    margin-left: 100px;
                    /* margin-right: 200px !important; */
                }

                #supervisor h6 {
                    text-align: justify !important;
                    font-size: 10px !important;
                }

                #supervisor input {
                    text-align: center !important;
                    border-top: none !important;
                    border-left: none !important;
                    border-right: none !important;
                    border-bottom: 1px solid black !important;
                }

                #infoInput {
                    position: relative !important;
                    bottom: 10px !important;
                    left: 130px !important;
                }

                .rubrica_supervisor {
                    position: absolute;
                    right: 180px;
                    top: 65px;
                }
            </style>
            <div id="supervisor">
                <!--  Recomendaciones y advertencias -->
                <table class="mb-2  ">
                    <tbody>
                        <tr>
                            <td class=" d-flex pb-2 px-3 ">
                                <label class=" h7 d-flex">
                                    NOTA 1:
                                    <strong class="h7">
                                        USAR UNICAMENTE TINTA AZUL PARA EL REGISTRO DE TEMPERATURA
                                    </strong>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex  px-3 ">
                                <div class="d-flex h7">
                                    NOTA 2:
                                    <strong class="h7">
                                        SI DETECTA UNA TEMPERATURA INADECUADA, ÉSTA DEBERÁ AJUSTARSE Y DE NO CONTROLARSE SE INFORMARÁ AL JEFE INMEDIATO PARA TOMAR LAS MEDIDAS PERTINENTES.
                                    </strong>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Fin recomendaciones y advertencias -->

                <!-- ================================================================================================ -->

                <!-- Campos del supervisor -->
                <div class="d-flex mb-3 " style="width: max-content !important;">
                    <label class="h7 w-50"> OBSERVACIONES:</label>
                    <input class="h7 p-0 m-0" type="text" value="<?php echo $array['USUARIO']['OBSERVACIONES']; ?>" style="  width: 750px !important;">
                </div>

                <div class="d-flex " style="width: max-content !important;">
                    <div>
                        <label class="h7 w-50"> SUPERVISO:</label>
                        <input class="h7 p-0 m-0" type="text" value="<?php echo $array['USUARIO']['NOMBRE']; ?>" style="  width:200px  !important; margin-right:30px !important;">
                        <input class="h7 p-0 m-0" type="text" value="<?php echo $array['USUARIO']['CARGO']; ?>" style="  width:170px  !important; margin-right:30px !important;">
                        <input class="h7 p-0 m-0" type="text" value="<?php echo $array['USUARIO']['FECHA']; ?>" style="  width:150px  !important; margin-right:30px !important;">
                        <input class="h7 p-0 m-0" type="text" value="<?php echo $array['USUARIO']['FIRMA']; ?>" style="  width:150px  !important;">

                        <?php echo "<img class='rubrica_supervisor' src='data:image/png;base64, " . $encode_rubrica_supervisor . "' height='35'>"; ?>
                    </div>
                    <div class="d-flex" id="infoInput">
                        <span class="h7 p-0 m-0 subtitle" style="margin-right:190px !important;">NOMBRE</span>

                        <span class="h7 p-0 m-0 subtitle" style="margin-right:160px !important;">CARGO</span>

                        <span class="h7 p-0 m-0 subtitle" style="margin-right:150px !important;">FECHA</span>

                        <span class="h7 p-0 m-0 subtitle">FIRMA</span>
                    </div>
                </div>
                <!-- Fin campos del supervisor -->
            </div>

            <!-- Fin campos del supervisor -->


            <!-- Footer  -->
            <style>
                #footer label {
                    color: rgb(000, 078, 089);
                    font-size: 10.5px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                    font-weight: bold;
                    /* margin-right: 275px; */
                }

                #footer .container_footer {
                    position: relative;
                    top: 360px;
                    left: 80px;
                }
            </style>
            <div id="footer">
                <div class="container_footer">
                    <label class="" style='margin-right:300px;'>
                        REV .: 2023-03-31
                    </label>
                    <label class="" style='margin-right:380px;'>
                        FUG-08-DB
                    </label>
                    <label class="">
                        Pagina 1
                    </label>
                </div>

            </div>
            <!-- Fin del footer -->
        </div>
    </div>



    <!-- Imprimir variables de PHP -->
    <?php

    // echo "<pre>";

    // var_d    ump($data);
    // echo "</pre>";
    ?>
</body>

</html>