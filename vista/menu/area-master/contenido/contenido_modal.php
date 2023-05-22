<?php
$form = $_POST['form'];
$tipovista = $_POST['tipovista'];
$control_turnos = $_POST['control_turnos'];
session_start();

?>
<!-- <div class="col-12 loader" id="loader" style="">
  <div class="preloader" id="preloader"> </div>
</div> -->
<!-- <div class="row">
  <div class="card col-12 col-lg-3 pt-4">
    <div class="" id="panel-informacion">

    </div>
    <div class="" id="panel-resultadosMaster">

    </div>
  </div>
  <div class="card col-12 col-lg-9" style="margin-bottom:5px">
    <div class="text-center" style="margin-top:4px;zoom:95%;margin-bottom:5px;">
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-analisis-pdf">
        <i class="bi bi-clipboard2-plus"></i> Subir interpretación
      </button>
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-capturas-pdf">
        <i class="bi bi-clipboard2-plus"></i> Guardar capturas
      </button>
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-analisis-oftalmo">
        <i class="bi bi-clipboard2-plus"></i> Subir resultados 2
      </button>
    </div>
    <table class="table table-hover display responsive tableContenido" id="TablaContenidoResultados" style="width: 100%">
      <thead class="" style="width: 100%">
        <tr>
          <th scope="col d-flex justify-content-center" class="all">#</th>
          <th scope="col d-flex justify-content-center" class="all">Nombre</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Prefolio</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Procedencia</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Edad</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Sexo</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div> -->


<div class="col-12 loader" id="loader">
    <div class="preloader" id="preloader"> </div>
</div>
<div class="row">
    <div class="col-3 col-lg-4" style="margin-right: -5px !important;">
        <div class="card mt-3 p-3" id="lista-pacientes">
            <h4>Lista de pacientes</h4>

            <?php if ($control_turnos) : ?>
                <!-- Control de turnos -->
                <div id="turnos_panel"></div>
            <?php endif; ?>


            <div class="text-center mt-2">
                <div class="input-group flex-nowrap">
                    <!-- <span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="left" title="Los iconos representan el estado del paciente a las areas">
                        <i class="bi bi-info-circle"></i>
                    </span> -->
                    <input type="search" class="form-control input-color" aria-controls="TablaEstatusTurnos" style="display: unset !important; margin-left: 0px !important" name="inputBuscarTableListaPacientes" placeholder="Filtrar coincidencias" id="inputBuscarTableListaPacientes" data-bs-toggle="tooltip" data-bs-placement="top" title="Filtra la lista por coincidencias">
                    <span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="top" title="Una vez cargado o confirmado el reporte de un registro de esta area, aparecerán en verde">
                        <i class="bi bi-info-circle"></i>
                    </span>

                </div>
            </div>



            <!-- <div class="text-center">

                <label for="inputBuscarTableListaNuevos">Buscar:</label>
                <input type="text" class="form-control input-color" style="display: unset !important;width:auto !important" name="inputBuscarTableListaPacientes" value="" style="width:80%" autocomplete="off" id="inputBuscarTableListaPacientes">
            </div> -->
            <table class="table display responsive" id="TablaContenidoResultados" style="width: 100%">
                <thead class="" style="width: 100%">
                    <tr>
                        <th scope="col d-flex justify-content-center" class="all">#</th>
                        <th scope="col d-flex justify-content-center" class="all">Nombre</th>
                        <th scope="col d-flex justify-content-center" class="min-tablet">Prefolio</th>
                        <th scope="col d-flex justify-content-center" class="none">Cliente</th>
                        <th scope="col d-flex justify-content-center" class="none">Segmento</th>
                        <th scope="col d-flex justify-content-center" class="none">Turno</th>
                        <th scope="col d-flex justify-content-center" class="none">Sexo</th>
                        <th scope="col d-flex justify-content-center" class="none">Expendiente</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-3 col-lg-4 informacion-paciente" style="margin-right: -5px !important;display:none">
        <div class="card m-3" id="panel-informacion"> </div>
        <!-- <div class="card m-3 p-4">
      <h4>Estudios anteriores</h4>
      <div class="accordion" id="accordionResultadosAnteriores">
      </div>
    </div> -->
    </div>
    <div class="col-lg-4 informacion-paciente" style="margin-right: -5px !important;display:none">
        <div class="card mt-3 p-3" id="panel">
            <div class="" id="divAreaMasterResultados">
                <div class="row">
                    <div class="col-12">
                        <h4>Resultados</h4>
                        <?php
                        if ($tipovista == 'tomaCapturas') {
                            echo '<p class="none-p">Capture las imagenes del paciente</p>';
                        } else {
                            echo '<p class="none-p">Interprete o visualice el reporte del paciente</p>';
                        } ?>
                    </div>
                    <div class="row">
                        <?php if ($tipovista != 'tomaCapturas') : ?>
                            <div class="col-6 text-start" style="margin-top:4px;margin-bottom:5px;">
                                <button type="button" class="btn btn-primary me-2 btnResultados" style="margin-bottom:4px" id="btn-capturas-pdf">
                                    <i class="bi bi-plus-lg"></i> Imágenes
                                </button>
                            </div>
                            <div class="col-6 text-end" style="margin-top:4px;margin-bottom:5px;">
                                <!-- Subir por areas -->
                                <button type="button" id="abrirModalResultados" class="btn btn-confirmar me-2" style="margin-bottom:4px">
                                    <i class="bi bi-clipboard2-plus"></i> Interpretación
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($tipovista == 'tomaCapturas') { ?>
                    <!-- Visualizar imagenes por vista -->
                    <div class="vistaImagenesCargo5 mt-4 m-3" id="vistaCapturasAreas">
                        <ol class="list-group list-group-numbered" id="vistaEstudiosImagenes">
                            <!-- Lista de estudios a subir -->

                        </ol>
                    </div>
                <?php } else { ?>
                    <div id="spamResultado">

                    </div>
                    <div id="mostrarResultado" style="display: none;">

                        <h5>Resultados del paciente:</h5>
                        <div class="accordion" id="resultadosServicios-areas">

                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-8 d-flex justify-content-center align-items-center" id='loaderDivPaciente' style="max-height: 75vh; display:none">
        <div class="preloader" id="loader-paciente"></div>
    </div>
</div>

<div>
    <div class="modal fade" id="modalSubirInterpretacion" tabindex="-1" aria-labelledby="resultados" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title" id="title-paciente_aceptar">Reporte de interpretación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- <div class="col-12 col-lg-7">
                            <h4>Reporte de interpretación</h4>
                            <p class="none-p"></p>
                        </div> -->
                        <div class="row">
                            <!-- <div class="col-6 text-start" style="margin-top:4px;margin-bottom:5px;">
                                <button type="button" class="btn btn-hover me-2 btnResultados" style="margin-bottom:4px" id="btn-capturas-pdf">
                                    <i class="bi bi-clipboard2-plus"></i> Cargar capturas
                                </button>
                            </div>
                            <div class="col-6 text-end" style="margin-top:4px;margin-bottom:5px;">
                                <button type="button" class="btn btn-confirmar me-2 btnResultados" style="margin-bottom:4px" id="btn-analisis-pdf">
                                    <i class="bi bi-clipboard2-plus"></i> Guardar reporte
                                </button>



                                <button type="submit" form="formSubirInterpretacion" class="btn btn-confirmar me-2 btnResultados" style="margin-bottom:4px" id="btn-analisis">
                                    <i class="bi bi-clipboard2-plus"></i> Subir Reporte
                                    BTN para formulario global 
                                </button>
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">

                            <?php
                            switch ($form) {
                                    //<!-- Resultados de oftalmologia -->
                                case 'formSubirInterpretacionOftalmo':
                                    echo '<form id="formSubirInterpretacionOftalmo">';
                                    include 'forms/oftalmo.html';
                                    echo '</form>';
                                    break;

                                    //<!-- Resultados de oftalmologia -->
                                case 'formSubirInterpretacionElectro':
                                    echo '<form id="formSubirInterpretacionElectro">';
                                    include 'forms/electro.html';
                                    echo '</form>';
                                    break;

                                    //<!-- Formulario general -->
                                case 'formSubirInterpretacion':
                                    echo '<form id="formSubirInterpretacion">';
                                    include 'forms/form_general.html';
                                    echo '</form>';
                                    break;
                                case 'formSubirInterpretacionCitologia':
                                    echo '<form id="formSubirInterpretacionCitologia">';
                                    include 'forms/form_citologia.html';
                                    echo '</form>';
                                    break;
                            }

                            ?>
                        </div>
                    </div>
                    <img id="full" class="hideimg" src="http://localhost/nuevo_checkup/archivos/sistema/temp/transparent.png" border="0" onclick="this.className='hideimg'">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Regresar</button>
                    <!-- <button type="button" class="btn btn-cancelar" id="siguienteForm"><i class="bi bi-arrow-right-circle"></i> Siguiente</button> -->

                    <button type="button" class="btn btn-borrar btnResultados" id="btn-ver-reporte" data-bs-toggle="tooltip" data-bs-placement="top" title="La vista previa del reporte una vez guardado los cambios">
                        <i class="bi bi-file-earmark-pdf"></i> Vista previa
                    </button>
                    <!-- BTN oftalmo -->
                    <button type="submit" form="formSubirInterpretacionOftalmo" class="btn btn-confirmar btnResultados" id="btn-inter-oftal" data-bs-toggle="tooltip" data-bs-placement="top" title="Guarda los cambios del reporte si desea ver la vista previa">
                        <i class="bi bi-clipboard2-plus"></i> Guardar Interpretación
                    </button>
                    <!-- BTN GLOBAL -->
                    <button type="submit" form="<?php echo $form; ?>" class="btn btn-confirmar btnResultados" id="btn-inter-areas" data-bs-toggle="tooltip" data-bs-placement="top" title="Guarda los cambios del reporte si desea ver la vista previa">
                        <i class="bi bi-clipboard2-plus"></i> Guardar Interpretación
                    </button>

                    <button type="button" class="btn btn-confirmar btnResultados" id="btn-confirmar-reporte" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirme el reporte una vez guardado los cambios">
                        <i class="bi bi-file-earmark-pdf"></i> Confirmar reporte
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function popimg(URL, DAT) {
        console.log(document.body.clientWidth)

        // if (document.body.clientWidth < 480) return false;
        var full = document.getElementById("full");
        full.className = "showimg";
        full.title = DAT;
        full.src = URL;
        return true;
    }

    var body = $('body');

    body.on({
        click: function() {
            var src = $(this).attr('src');
            let div = $('<div class="slide" title="Teclea enter para salir de la imagen">');
            div.css({
                background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
                backgroundSize: 'contain',
                width: '100%',
                height: '100%',
                position: 'fixed',
                zIndex: '10000',
                top: '0',
                left: '0',
                cursor: 'pointer'
            }).appendTo('body');
            body.keyup(function(e) {
                if (e.key === "Enter") {
                    // img.remove();
                    div.remove();
                }
            })
            var scroll_zoom = new ScrollZoom(div, 5, 0.5)
        }
    }, 'img[data-enlargable]')

    // $('img[data-enlargable]').addClass('img-enlargable').click(function() {

    // });
</script>
<style>
    #TablaContenidoResultados_filter {
        display: none
    }
</style>