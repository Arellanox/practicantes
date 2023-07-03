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
                                echo "<img src='data:image/png;base64, " . $encode . "' height='55' >";
                                // echo "<img src='data:image/png;base64," . $barcode . "' height='75'>";
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabla de equipos y Termometro -->
            <div class="body mt-2  mx-7">
                <table>
                    <tbody>
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
                            <div class="mx-2"></div>
                            <td class="col-foot-izq" style="border-bottom: none; text-align:center;">
                                <!-- Tabla termometros -->
                                <div class="tabla-termometros">
                                    <table class="">
                                        <thead class="border-top border-left border-right ">
                                            <tr class="p-0 m-0">
                                                <th colspan="3" class="bg-title">
                                                    <h6>Termometros</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="border">
                                            <tr class="">
                                                <td class="">
                                                    <h6>
                                                        R1C1
                                                    </h6>
                                                </td>
                                                <td class="">
                                                    <h6>
                                                        R1C2
                                                    </h6>
                                                </td>
                                                <td class="">
                                                    <h6>
                                                        R1C3
                                                    </h6>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="">
                                                    <h6>
                                                        Item
                                                    </h6>
                                                </td>
                                                <td class="">
                                                    <h6>
                                                        Item
                                                    </h6>
                                                </td>
                                                <td class="">
                                                    <h6>
                                                        Item
                                                    </h6>
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


        </div>

    </div>

</body>


</html>