<!-- tabs para movil -->
<div id="tab-button"></div>

<div class="row">
    <div class="col-12" id="tab-principal">
        <div class="row">
            <div class="col-12 col-xl-3">
                <!-- Lista de los equipos a los que se debe capturar temperaturas -->
                <div class="col-12">
                    <div class="card mt-3 p-3" id="lista-pacientes">
                        <h5>Lista de Equipos Enfriadores</h5>

                        <form name="EquiposTemperaturasForm" id="EquiposTemperaturasForm">
                            <div class="mb-3">
                                <label for="Equipo" class="form-label p-0 m-0">Equipo:</label>
                                <select class="form-select input-form" name="Equipos" id="Equipos" required>
                                    <option selected>Eliga un equipo</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end d-block d-lg-flex d-print-block">
                                <button type="button" class="btn btn-pantone-3165 me-2 disable-element" id="CapturarTemperaturabtn">
                                    <i class="bi bi-arrow-bar-up"></i> Capturar
                                </button>
                                <button class="btn btn-confirmar me-2 disable-element" id="btn-desbloquear-equipos">
                                    <i id="btn-lock" class="bi bi-lock-fill"></i>
                                </button>
                                <button type="submit" form="EquiposTemperaturasForm" class="btn btn-confirmar " id="btn-equipo-temperatura">
                                    <i class="bi bi-thermometer-half"></i> Mostrar
                                </button>


                            </div>
                        </form>
                    </div>
                </div>
                <!-- Tabla de los meses que se tienen registrado de los equipo -->
                <div class="col-12" id="lista-meses-temperatura" style="margin-right: -5px !important; display:none;">
                    <div class="card mt-3 p-3 ">
                        <h5>Lista de Registro por Meses</h5>
                        <!-- <div class="d-flex justify-content-center my-2" id="btn-temperaturas-actions">
                            <button type="button" class="btn btn-borrar me-2" style="margin-bottom:4px; display:none ;" id="GenerarPDFTemperatura">
                                <i class="bi bi-file-earmark-pdf-fill"></i> Generar PDF
                            </button>
                        </div> -->
                        <!-- Control de turnos -->
                        <div id="turnos_panel"></div>
                        <table class="table display responsive" id="TablaTemperaturasFolio" style="width: 100%">

                        </table>
                    </div>
                </div>
                <!-- Loader que carga cuando la tabla se esta llenando -->
                <div class="col-12 d-flex justify-content-center align-items-center" id='loaderDivtemperatura2' style="max-height: 75vh; display: none; ">
                    <div class="preloader" id="loader-temperatura2"></div>
                </div>
            </div>
            <div class="col-12 col-xl-9">
                <div class="row" id="Equipos_Termometros" style="display: none;">
                    <!-- Informacion del equipo y termometro asignados -->
                    <div class="col-12">
                        <div class="mt-3">
                            <div class="row gap-3">
                                <!-- Informacion del equipos -->
                                <div class='col card p-3'>
                                    <p class="text-center mb-2">Equipo</p>
                                    <div id="Tabla-equipos">
                                    </div>
                                </div>

                                <!-- Informacion del termometro -->
                                <div class='col card p-3'>
                                    <p class="text-center mb-2">Termometro</p>
                                    <div id="Tabla-termometro">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Grafica -->
                    <div class="col-12 tab-second  grafica-temperatura" id="tab-informacion" style="margin-right: -5px !important; display:none !important;">
                        <div class="card mt-3 p-3 ">
                            <div class="table--container" style="width: fit-content;" id="grafica">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Tercera Columna visual -->
<div id="reload-selectable">

</div>


<!-- Modal de comentarios de los registros -->
<div class="modal-comentarios">
    <div class="modal fade" id="modalComentariosRegistro" tabindex="-1" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registro: <strong id="fecha_comentario">FECHA[]</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h5>Agregar comentario del día</h5>
                            <form class="row" id="formAgregarComentario">
                                <div class="mb-3">
                                    <label for="comentario">Comentario:</label>
                                    <!-- <input type="text" name="comentario" value="" class="form-control input-form" readonly disabled> -->
                                    <textarea name="comentario" class="form-control input-form" cols="30" rows="4"></textarea>
                                </div>
                                <div class="d-flex justify-content-end my-auto">
                                    <button type="submit" class="btn btn-confirmar" form="formAgregarComentario">
                                        <i class="bi bi-plus"></i> Agregar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-lg-12">
                            <div id="content-comentarios-registros">
                                <div class="card m-3 p-3">
                                    <h5>Comentario creado por</h5>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo libero obcaecati necessitatibus doloremque. Incidunt ad, alias corrupti nihil est cupiditate rerum itaque illo consequuntur quis aliquid laboriosam possimus magnam ipsa.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left-short"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- OffCanvas Configuracion Temperaturas -->
<!-- OffCanvas -->
<div class="offcanvas offcanvas-end bg-navbar" tabindex="-1" id="offcanvasConfiguracionTemperaturas" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <div class="d-flex align-items-center mb-md-0 me-md-auto text-white text-decoration-none">
            <!-- <img src="https://www.bimo-lab.com/archivos/sistema/LogoConFondoAppAndroid.png" style="height: 36px;margin-right: 20px;" /> -->
            <span class="fs-4">
                <i class="bi bi-gear-fill"></i>
                Configuracion</span>
        </div>
        <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="bg-white" style="background-color: #fff !important;">
    <div class="offcanvas-body">
        <div class="row">
            <form name="ConfiguracionTemperaturaForm" id="ConfiguracionTemperaturaForm">
                <div class="col-12 mb-4">
                    <div class="mb-3 text-center">
                        Habilitar o Deshabilitar los Domingos
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="Domingos" checked>
                        <label class="form-check-label" for="Domingos">
                            <div class="text-light">Domingos Activos</div>
                        </label>
                    </div>

                </div>
                <hr>
                <div class="col-12">
                    <div class="mb-3 text-center">
                        Horarios de Turno
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="text-light" for="">M-Inicio</label>
                                <input type="time" name="matutino_inicio" class="form-control " id="matutino_inicio">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="text-light" for="">M-Final</label>
                                <input type="time" name="matutino_final" class="form-control " id="matutino_final">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="text-light" for="">V-Inicio</label>
                                <input type="time" name="vespertino_inicio" class="form-control " id="vespertino_inicio">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="text-light" for="">V-Final</label>
                                <input type="time" name="vespertino_final" class="form-control " id="vespertino_final">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>



            </form>
            <button type="submit" form="ConfiguracionTemperaturaForm" class=" btn btn-confirmar" id="btn-configuracion-temperatura">
                <i class="bi bi-thermometer-half"></i> Guardar
            </button>

        </div>
    </div>
</div>

<style media="screen">
    /*    #TablaTemperaturasFolio_filter {
        display: none
    } */

    /* #capturarTemperatura {
        display: none;
    }
 */
    @media (max-width: 768px) {

        /*  #capturarTemperatura {
            display: contents;
        }
 */
        #formularioDesktopTemperatura {
            display: none;
        }
    }
</style>