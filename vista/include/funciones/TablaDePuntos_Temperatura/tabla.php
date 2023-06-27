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
                            $url = "http://localhost/practicantes/api/temperatura_api.php";
                            // Los datos de formulario
                            $datos = [
                                "api" => 7,
                                "folio" => $_POST['folio'],
                            ];
                            // Crear opciones de la petición HTTP
                            $opciones = array(
                                "http" => array(
                                    "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                                    "method" => "POST",
                                    "content" => http_build_query($datos), # Agregar el contenido definido antes
                                ),
                            );
                            # Preparar petición
                            $contexto = stream_context_create($opciones);
                            # Hacerla
                            $json = file_get_contents($url, false, $contexto);

                            $array = json_decode($json, true);


                            $max = $array['response']['data']['EQUIPO']['INTERVALO_MAX'];
                            $min = $array['response']['data']['EQUIPO']['INTERVALO_MIN'];

                            $valores = $array['response']['data']['DIAS'];

                            $dotInicial =  array_key_first($valores);
                            $dotEnd =  array_key_last($valores);

                            function redondear($valor, $valorAprox, $min,  $max)
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

                                $pixeles = (($explode[1] / 100) * 30) + 10;

                                if ($valor >= $max) {
                                    $pixeles = 10;
                                    $explode[0] = $max;
                                }

                                if ($valor <= $min) {
                                    $pixeles = 10;
                                    $explode[0] = $min;
                                }


                                return [$explode[0], $pixeles . "px"];


                                // return $explode[0];
                            }

                            function metodoCalculo($dia, $turno, $valorAprox, $valores, $min, $max)
                            {
                                // global $valores;
                                // global $max;
                                // global $min;
                                if ($valores[$dia][$turno]) {

                                    // $valor = floatval($valores[$dia][$turno]["valor"]);
                                    // $valor_redondeado = round($valor);
                                    $valor = $valores[$dia][$turno]["valor"];
                                    $valor_turno = redondear($valores[$dia][$turno]["valor"], $valorAprox, ($min - 5), ($max + 5));
                                    $valor_redondeado = $valor_turno[0];
                                    $valor_decimal_px = $valor_turno[1];

                                    $color = $valores[$dia][$turno]['color'];
                                    $id = $valores[$dia][$turno]['id'];
                                    if ($valor_redondeado == $valorAprox) {
                                        $dotId = "dot-$dia-$turno"; // Generar el ID del dot

                                        if ($valorAprox <= ($max - 1) && $valorAprox >= $min) {
                                            return "<td class='td-hover bg-grey empty turno-$turno'  data_id='$id'><div id='$dotId' class='dot dot-div dot-$color' style='top:$valor_decimal_px' data-bs-toggle='tooltip' data-bs-placement='top' title='$valor °C'></div></td>";
                                        } else {
                                            return "<td class='td-hover empty turno-$turno'  data_id='$id'><div id='$dotId' class='dot dot-div dot-$color' style='top:$valor_decimal_px' data-bs-toggle='tooltip' data-bs-placement='top' title='$valor °C'></div></td>";
                                        }
                                    }
                                }

                                if ($valorAprox <= ($max - 1) && $valorAprox >= $min) {
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
                                    echo "<tr>";
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
                                    echo metodoCalculo($i, 1, $j, $valores, $min, $max);
                                    echo metodoCalculo($i, 2, $j, $valores, $min, $max);
                                    echo metodoCalculo($i, 3, $j, $valores, $min, $max);
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


                            // echo "<tr class='border'>";
                            // echo "<th class='celdasDias' style='min-heigth: 20px'></th>";
                            // for ($i = 1; $i <= 31; $i++) {
                            //     echo "<td class='bg-grey empty '></td>";
                            //     echo "<td class='bg-grey empty '></td>";
                            //     echo "<td class='bg-grey empty '></td>";
                            // }
                            // echo "</tr>";
                            ?>
                      </table>

                      <canvas id="canvas"></canvas>

                      <script>
                          var dotInicial = <?php echo array_key_first($valores); ?>;

                          var dotLast = <?php echo array_key_last($valores); ?>;
                      </script>
                      <style>
                          #grafica table {
                              border-collapse: collapse;
                          }

                          #grafica th,
                          #grafica td {
                              border: 2px solid black;
                              padding: 1px;

                          }

                          #grafica td.empty {
                              margin-left: auto;
                              margin-right: auto;
                              padding: 0px;
                              /* width: 20px; */
                              min-width: 14px;
                              max-width: 14px;
                              max-height: 14px;
                              min-height: 14px;
                          }



                          .border-top {
                              border-top: 3px solid !important;
                          }

                          .border-bottomm {
                              border-bottom: 3px solid !important;
                          }


                          .turno-1 {
                              border: 0.02px dashed black !important;
                          }

                          .turno-2 {
                              border: 0.02px dashed black !important;
                          }

                          .turno-3 {
                              border-left: 0.02px dashed black !important;
                              border-top: 0.02px dashed black !important;
                              border-bottom: 0.02px dashed black !important;
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
                              /* font-size: 20px !important; */
                              font-weight: bold !important;
                              padding-top: 5px;
                              padding-bottom: 5px;
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
                              -moz-border-radius: 7.5px;
                              -webkit-border-radius: 7.5px;
                              border-radius: 7.5px;
                              z-index: 100;
                              position: absolute;
                              /* background-color: #69b6d5; */
                          }

                          .dot-div {
                              position: relative;
                              /* top: 10px; */
                              left: 8.7px;
                              min-height: 0px;
                              max-height: 0px;
                              cursor: pointer;
                          }

                          .dot-div:hover {
                              background-color: rgb(0 175 170 / 60%)
                          }


                          /* .dot-div::after {
                              background-color: #ffa209;
                              border-radius: 50%;
                          } */

                          .dot-blue::before {
                              background-color: blue;
                          }

                          .dot-mostaza::before {
                              background-color: #ffa209;
                          }

                          #grafica canvas {
                              position: absolute;
                              top: 42.4px;
                              left: 31px;
                              pointer-events: none;
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

                          /* .table--container {

                              display: flex !important;
                              justify-content: center;
                          } */

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