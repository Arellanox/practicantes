                      <table>
                          <tr>
                              <th class="celdasDias"></th>
                              <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    echo "<th class='diaHeader' colspan='2'>" . $i . "</th>";
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

                            foreach ($array['response'] as $key1 => $e) {
                                $valores = $e;
                            }

                            $dotInicial =  array_key_first($valores);
                            $dotEnd =  array_key_last($valores);




                            function metodoCalculo($dia, $turno, $valorAprox)
                            {
                                global $valores;
                                if (isset($valores[$dia]) && isset($valores[$dia][$turno])) {
                                    $valor = floatval($valores[$dia][$turno]["valor"]);
                                    $valor_redondeado = round($valor);
                                    $color = $valores[$dia][$turno]['color'];
                                    $id = $valores[$dia][$turno]['id'];
                                    if ($valor_redondeado == $valorAprox) {
                                        $dotId = "dot-$dia-$turno"; // Generar el ID del dot
                                        return "<td class='td-hover empty turno-$turno background$valorAprox dot dot-$color' data_id='$id' id='$dotId'>&#8226;</td>";
                                    }
                                }
                                return "<td class='empty turno-$turno background$valorAprox'></td>";
                            }

                            // Generar las celdas de la tabla
                            for ($j = -40; $j <= -20; $j++) {
                                echo "<tr class='border$j'>";
                                echo "<th class='celdasDias text$j'>" . $j . "</th>";

                                $prevDot = null; // Dot previo para conectar con líneas

                                for ($i = 1; $i <= 31; $i++) {
                                    $dot1 = metodoCalculo($i, 1, $j);
                                    $dot2 = metodoCalculo($i, 2, $j);
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
                              padding: 3.4px;
                              width: 20px;
                          }

                          .td-hover:hover {
                              background-color: rgb(0 175 170 / 60%)
                          }

                          .td-hover {
                              cursor: pointer
                          }




                          .border-34 {
                              border-top: 3px solid !important;
                          }

                          .border-25 {
                              border-bottom: 3px solid;
                          }

                          .background-25,
                          .background-26,
                          .background-27,
                          .background-28,
                          .background-29,
                          .background-30,
                          .background-31,
                          .background-32,
                          .background-33,
                          .background-34 {
                              background-color: #d8dfe1;
                          }

                          .turno-1 {
                              border: 2px dashed black !important;
                          }

                          /* .turno-2 {
                border: 2px dashed black !important;
                } */

                          .turno-2 {
                              border-left: 2px dashed black !important;
                              border-top: 2px dashed black !important;
                              border-bottom: 2px dashed black !important;
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

                          .text-25,
                          .text-35 {

                              font-weight: bold !important;
                              padding-top: 5px;
                              padding-bottom: 5px;
                          }

                          .dot {
                              font-size: 30px;
                              text-align: center !important;
                          }

                          .dot-blue {
                              color: blue;
                          }

                          .dot-mostaza {
                              color: #ffa209;
                          }

                          #grafica canvas {
                              position: absolute;

                              top: 27px;
                              left: 24px;
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




                          ;
                      </style>