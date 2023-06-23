<?php
/* $folio = $_POST['folio']; */
?>

<!DOCTYPE html>
<html>


<body>

    <div id="elemento-a-exportar">

        <head>
            <style>
                #grafica {
                    border-collapse: collapse;
                    /* transform: scale(0.5); */
                    /* zoom: 50%;
                    transform-origin: top left; */

                }



                #body {
                    background-color: aqua;
                    position: fixed;
                    top: -40px;
                    left: -40px;
                    right: -40px;
                    /* bottom: 40px; */
                    height: 111%;
                }

                #grafica th,
                #grafica td {
                    border: 2px solid black;
                    padding: 7px;

                }

                #grafica td.empty {
                    margin-left: auto;
                    margin-right: auto;
                    /* padding: 3.4px; */
                    padding: 0px;
                    width: 20px;
                }

                .border-top {
                    border-top: 3px solid !important;
                }

                .border-bottomm {
                    border-bottom: 3px solid !important;
                }

                /*
                .background2,
                .background3,
                .background4,
                .background5,
                .background6,
                .background7,
                .background8 {
                    background-color: #d8dfe1;
                }

                */
                .turno-1 {
                    border: 2px dashed black !important;
                }

                /*  .turno-2 {
            border: 2px dashed black !important;
        } */

                .turno-2 {
                    border-left: 2px dashed black !important;
                    border-top: 2px dashed black !important;
                    border-bottom: 2px dashed black !important;
                }


                .td-hover:hover {
                    background-color: rgb(0 175 170 / 60%)
                }

                .td-hover {
                    cursor: pointer
                }

                .td-hover::after {
                    background-color: #ffa209;
                    border-radius: 50%;
                }


                .celdasDias {
                    font-weight: normal !important;
                    border-left: none !important;
                    border-top: 5px solid #0000 !important;
                    border-bottom: none !important;
                }

                .diaHeader {
                    padding: 2px !important;
                    background-color: #d8dfe1 !important;
                }

                .text-rango {
                    font-size: 20px !important;
                    font-weight: bold !important;
                    padding-top: 5px;
                    padding-bottom: 5px;
                    width: 35px;
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

                    padding-left: 3px;
                    padding-bottom: 11px;

                }

                .dot::before {
                    content: '';
                    display: inline-block;
                    width: 12px;
                    height: 12px;
                    -moz-border-radius: 7.5px;
                    -webkit-border-radius: 7.5px;
                    border-radius: 7.5px;
                    z-index: 100;
                    position: absolute;
                    /* background-color: #69b6d5; */
                }

                .dot-blue::before {
                    background-color: blue;
                }

                .dot-mostaza::before {
                    background-color: #ffa209;
                }



                #equipo {
                    width: 900px;
                    border: 1px solid black;
                    margin-left: 10px;
                    margin-right: 10px;
                }

                .equipo-header {
                    align-self: center;
                    margin-top: auto;
                    margin-bottom: auto;
                    background: #d8dfe1;
                    height: 20px;
                    display: flex;
                    justify-content: center;
                    border-bottom: 1px solid black;
                }

                .equipo-header h5 {
                    align-self: center;
                }

                .equipo-body {
                    display: flex;
                    margin-top: 5px;
                    margin-bottom: 5px;
                    margin-right: 30px;
                }

                .equipo--input {
                    display: flex;
                    justify-content: center;
                    align-self: center;
                    width: 170px !important;
                    border-bottom: 2px solid black;
                }

                .equipo--container {
                    height: 20px !important;
                    display: flex;
                    padding: 5px 20px;
                }

                label {
                    font-size: 15px;
                }



                .container {
                    display: flex !important;
                    justify-content: center;
                    margin-left: auto;
                    margin-right: auto;
                }


                .bg-grey {
                    background-color: #d8dfe1;

                }
            </style>


        </head>

        <div id="body">

            <div id="container-equipo">


            </div>

            <!-- <div class="container " style="display: flex;">
                <div id="equipo">
                    <div class="equipo-header">
                        <h5>EQUIPO</h5>
                    </div>
                    <div class="equipo--container">
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">Equipo:</label>
                            <small class="equipo--input">
                                CONGELADOR
                            </small>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">Modelo:</label>
                            <div class="equipo--input">
                                as
                            </div>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">Localización:</label>
                            <div class="equipo--input" style="width: 250px !important">
                                ass
                            </div>
                        </div>
                    </div>
                    <div class="equipo--container">
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">Marca:</label>
                            <div class="equipo--input">
                                <span></span>
                            </div>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">N° Serie:</label>
                            <div class="equipo--input" style="width: 260px !important">
                                <small></small>
                            </div>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">Intervalo Optimo:</label>
                            <div class="equipo--input" style="width:100px !important;">
                                <span style="font-weight: bold;">-25 A -35°C</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="equipo">
                    <div class="equipo-header">
                        <h5>TERMOMETRO</h5>
                    </div>
                    <div class="equipo--container">
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">Marca:</label>
                            <small class="equipo--input">
                                CONGELADOR
                            </small>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px; width:150px !important;">Factor de correción:</label>
                            <div class="equipo--input">
                                °C
                            </div>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">MES:</label>
                            <div class="equipo--input">
                                ass
                            </div>
                        </div>
                    </div>
                    <div class="equipo--container">
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">ID:</label>
                            <div class="equipo--input">
                                <span></span>
                            </div>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px; width:150px !important;">Fecha de verificación:</label>
                            <div class="equipo--input">
                                <small>s</small>
                            </div>
                        </div>
                        <div class="equipo-body">
                            <label style="margin-right: 5px;">AÑO:</label>
                            <div class="equipo--input">
                                <small>s</small>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
 -->

            <!-- Tabla de puntos -->
            <!-- <div>
                <table id="grafica">
                    <tr>
                        <th class="celdasDias"></th>
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo "<th class='diaHeader' colspan='2'>" . $i . "</th>";
                        }
                        ?>
                    </tr>


                    <?php


                    // Arreglo contruido

                    // echo '<pre>', var_dump($resultados), '</pre>';

                    // $array = json_decode($resultados, true);

                    $max = $resultados->EQUIPO->INTERVALO_MAX;
                    // echo '<pre>', var_dump($max), '</pre>';
                    // echo $max;
                    $min = $resultados->EQUIPO->INTERVALO_MIN;

                    // $max = $array['EQUIPO']['INTERVALO_MAX'];
                    // $min = $array['EQUIPO']['INTERVALO_MIN'];

                    // echo $max;

                    $valores_obj = $resultados->DIAS;
                    // echo '<pre>', var_dump($valores_obj), '</pre>';
                    $valores = [];
                    foreach ($valores_obj as $key => $value) {
                        # code...

                        foreach ($value as $key_2 => $value_2) {

                            foreach ($value_2 as $key_3 => $value_3) {
                                $valores[$key][$key_2][$key_3] = $value_3;
                            }
                        }
                    }

                    // echo '<pre>', var_dump($valores), '</pre>';

                    // $valores = json_decode($valores, true);

                    function redondear($valor, $valorAprox)
                    {

                        $explode = explode('.', $valor);
                        $signo = $explode[0] > 0 ? '' : '-';
                        $unidad = $explode[0] > 0 ? $explode[0]  : ($explode[0] * -1);
                        $decimal = $explode[1] > 50 ? 1 : 0;

                        $valor_final = ($unidad + ($decimal));
                        return "$signo$valor_final";


                        // return $explode[0];
                    }

                    function raangoTD($valorAprox, $min, $max)
                    {
                        $valores = [];
                        foreach (range($min, $max) as $number) {
                            // echo $number;
                            $valores[] = $number;
                            // return in_array($valorAprox, [$number]);
                        }

                        return in_array($valorAprox, $valores);
                    }

                    function metodoCalculo($dia, $turno, $valorAprox, $valores, $min, $max)
                    {

                        // global $valores;
                        // global $max;
                        // global $min;



                        if (in_array($valores[$dia][$turno], [$valores[$dia][$turno]])) {
                            $turno_dia = $valores[$dia][$turno];

                            // if ($turno_dia) {
                            //     return "<td>si</td>";
                            // } else {
                            //     return "<td>no</td>";
                            // }
                            $valor = redondear($valores[$dia][$turno]["valor"], $valorAprox);
                            // $valor_redondeado = round($valor);
                            $color = $valores[$dia][$turno]['color'];
                            $id = $valores[$dia][$turno]['id'];
                            // return "<td>$valor</td>";
                            if (in_array($valor, [$valorAprox])) {
                                $dotId = "dot-$dia-$turno"; // Generar el ID del dot
                                if (raangoTD($valorAprox, $min, $max)) {
                                    return "<td class='td-hover bg-grey empty turno-$turno'  data_id='$id' id='$dotId'><div class='dot dot-$color'></div></td>";
                                } else {
                                    return "<td class='td-hover empty turno-$turno'  data_id='$id' id='$dotId'><div class='dot dot-$color'></div></td>";
                                }
                            }
                        }

                        if (raangoTD($valorAprox, $min, $max)) {
                            return "<td class='bg-grey empty turno-$turno'></td>";
                        } else {
                            return "<td class='empty turno-$turno background$valorAprox'></td>";
                        }
                    }



                    // Generar las celdas de la tabla
                    for ($j = $max + 5; $j >= $min - 5; $j--) {
                        if ($j == $max) {
                            echo "<tr class='border-top'>";
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
                            $dot1 = metodoCalculo($i, 1, $j, $valores, $min, $max);
                            $dot2 = metodoCalculo($i, 2, $j, $valores, $min, $max);
                            /* $dot3 = metodoCalculo($i, 3, $j); */

                            if ($dot1 != '<td class="empty turno-1 background' . $j . '"></td>') {
                                echo $dot1;
                                if ($dot2 != '<td class="empty turno-2 background' . $j . '"></td>') {
                                    echo $dot2;
                                } else {
                                    $prevDot = null; // No hay dot en el turno 2, reiniciar dot previo
                                }
                            } else {
                                $prevDot = null; // No hay dot en el turno 1, reiniciar dot previo
                            }
                        }
                        echo "</tr>";
                    }
                    ?>

                </table>

            </div> -->

        </div>

    </div>

</body>


</html>