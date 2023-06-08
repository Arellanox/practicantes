<?php
foreach ($areas as $key => $area) {
    $a = 0;

    echo "<h2 style='padding-bottom: 5px; padding-top: 5px;'>" . $area->area . "</h2>";

    foreach ($area->estudios as $key => $estudio) {

        echo "<h4 style='padding-top: 9px'>" . $estudio->estudio . "</h4>";

?>
        <table class="result" style="padding-top: 1px;">
            <thead>
                <tr>
                    <th class="col-one">Nombre</th>
                    <th class="col-two">Resultado</th>
                    <th class="col-three">Unidad</th>
                    <th class="col-four">Referencia</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($estudio->analitos as $key => $analito) {
                    $a++;
                    if (is_array($analito)) {
                ?>
                        <tr>
                            <td class="col-one">
                                <strong>Valores absolutos</strong>
                            </td>
                            <td class="col-two">
                            </td>
                            <td class="col-three">
                            </td>
                            <td class="col-four">
                            </td>
                        </tr>
                        <?php
                        foreach ($analito as $b => $absoluto) {
                        ?>
                            <tr style="text-indent: 5px;">
                                <td class="col-one">
                                    <?php echo ($absoluto->analito != null) ? $absoluto->analito : '';  ?>
                                </td>
                                <td class="col-two">
                                    <?php echo ($absoluto->valor_abosluto != null) ? $absoluto->valor_abosluto : ''; ?>
                                </td>
                                <td class="col-three">
                                    <?php echo ($absoluto->unidad != null) ? $absoluto->unidad : ''; ?>
                                </td>
                                <td class="col-four">
                                    <?php echo ($absoluto->referencia != null) ? $absoluto->referencia : ''; ?>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <?php
                            if ($analito->resultado == 'N/A') {
                            } else {
                            ?>
                                <td class="col-one">
                                    <?php echo ($analito->nombre != null) ? $analito->nombre : '';  ?>
                                </td>
                                <td class="col-two">
                                    <?php echo ($analito->resultado != null) ? $analito->resultado : ''; ?>
                                </td>
                                <td class="col-three">
                                    <?php echo ($analito->unidad != null) ? $analito->unidad : ''; ?>
                                </td>
                                <td class="col-four">
                                    <?php echo ($analito->referencia != null) ? $analito->referencia : ''; ?>
                                </td>
                            <?php
                            }
                            ?>
                        </tr>
                        <?php
                        if (isset($analito->metodo) && $analito->metodo != null || $analito->metodo != '') {
                        ?>
                            <tr>
                                <td class="col-one" style="font-size: 12px">
                                    <?php echo "<strong style='font-size: 12px'>Método: </strong>" . $analito->metodo ?>
                                </td>
                                <td class="col-two">
                                </td>
                                <td class="col-three">
                                </td>
                                <td class="col-four">
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <?php

                        if (isset($analito->equipo) && $analito->equipo != null || $analito->equipo != '') {
                        ?>
                            <tr>
                                <td class="col-one" style="font-size: 12px">
                                    <?php echo "<strong style='font-size: 12px'>Equipo: </strong>" . $analito->equipo ?>
                                </td>
                                <td class="col-two">
                                </td>
                                <td class="col-three">
                                </td>
                                <td class="col-four">
                                </td>
                            </tr>
                        <?php
                        }

                        if (isset($analito->observaciones) && $analito->observaciones != null || $analito->observaciones != '') {
                        ?>
                            <tr>
                                <td class="col-one" style="font-size: 12px">
                                    <?php echo "<strong style='font-size: 12px'>Observaciones: </strong>" . $analito->observaciones ?>
                                </td>
                                <td class="col-two">
                                </td>
                                <td class="col-three">
                                </td>
                                <td class="col-four">
                                </td>
                            </tr>
                <?php
                        }

                        if ($estudio->estudio == 'OTROS SERVICIOS') {
                            echo "<br>";
                        }
                    }
                }
                ?>


            </tbody>
        </table>
        <div style="font-size: 12px">

            <?php
            if ($estudio->metodo == '' || $estudio->metodo == null) {
            } else {
                echo "<strong style='font-size: 12px'>Método: </strong>" . $estudio->metodo;
            }
            ?>
        </div>
        <div style="font-size: 12px">

            <?php
            if ($estudio->equipo == '' || $estudio->equipo == null) {
            } else {
                echo "<strong style='font-size: 12px'>Equipo: </strong>" . $estudio->equipo;
            }
            ?>
        </div>
        <div style="font-size: 12px">

            <?php
            if ($estudio->observaciones == '' || $estudio->observaciones == null) {
            } else {
                echo "<strong style='font-size: 12px'>Observaciones: </strong>" . $estudio->observaciones;
            }
            ?>
        </div>
        <?php

    }
    $i++;
    // $color_count % 2 == 0
    // $a < 15
    // if($a < 15){
    // }

    // if ($i < $count) {  
    //     echo '<div class="break"></div>';
    // }

    // echo $a;
    if ($a <= 15) {
    } else {
        if ($i < $count) {

            // echo "salto de linea";
        ?>
            <div class="break"></div>
    <?php
        }
        // echo '<div class="break">';
    }
    ?>

<?php
}
