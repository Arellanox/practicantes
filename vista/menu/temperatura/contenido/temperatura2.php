<!-- tabs para movil -->
<div id="tab-button"></div>

<div class="row">
    <div class="col-12 tab-first" id="tab-principal">
        <!-- Vista de equipo y formulario -->
        <div class="row">
            <div class="col-12 col-xl-3">
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
                            <button class="btn btn-confirmar me-2 disable-element" id="btn-desbloquear-equipos">
                                <i id="btn-lock" class="bi bi-lock-fill"></i>
                            </button>
                            <button type="submit" form="EquiposTemperaturasForm" class=" btn btn-confirmar" id="btn-equipo-temperatura">
                                <i class="bi bi-person-x"></i> Mostrar
                            </button>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-xl-9">
                <div class="card mt-3 p-3">
                    <form class="disable-element" id="formCapturarTemperatura" name="formCapturarTemperatura">
                        <div class="row">
                            <h5>Capture su lectura</h5>
                            <div class="col-12 col-xl-4 align-self-center">
                                <input type="hidden" name="Enfriador" id="Enfriador">
                                <div class="mb-3">
                                    <label for="termometro" class="form-label p-0 m-0">Termometro:</label>
                                    <select class="form-select input-form disable-element" name="Termometro" id="Termometro" required>

                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-xl-3">
                                <div class="mb-3">
                                    <label for="lectura">Lectura:</label>
                                    <div class="input-group mb-3">

                                        <input type="number" value="0" step="0.01" name="lectura" class="form-control input-form" required id="lectura">
                                        <span class="input-span">°C</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-5">
                                <div class="mb-3">
                                    <label for="observaciones">Observaciones:</label>
                                    <input type="text" name="observaciones" value="" class="form-control input-form" required id="observaciones">
                                    <!-- <input type="hidden" id="firma_guardar" name="firma" required /> -->
                                </div>
                            </div>
                            <div class="col-12 col-xl-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkFactorCorrecion">
                                    <label class="form-check-label" for="checkFactorCorrecion">
                                        Activar factor de correcion
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-xl-6 d-flex justify-content-end my-auto">
                                <!-- <button id="ModalFirmaTemperatura" class="btn btn-confirmar me-2"><i class="bi bi-pencil-square"></i></button> -->
                                <button type="submit" class=" btn btn-confirmar" id="btn-equipo-temperatura">
                                    <i class="bi bi-person-x"></i> Guardar
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-xl-3 tab-fist mb-3">
    <!-- Tabla de meses -->
    <div class="row">
        <div class="col-12" id="lista-meses-temperatura" style="margin-right: -5px !important; display:none;">
            <div class="card mt-3 p-3 ">
                <h5>Lista de Registro por Meses</h5>

                <!-- Control de turnos -->
                <div id="turnos_panel"></div>
                <table class="table display responsive" id="TablaTemperaturasFolio" style="width: 100%">
                    <thead class="">
                        <tr>
                            <th scope="col d-flex justify-content-center" class="all">#</th>
                            <th scope="col d-flex justify-content-center" class="all">Descripcion</th>
                            <th scope="col d-flex justify-content-center" class="min-tablet">Folio</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center align-items-center" id='loaderDivtemperatura2' style="max-height: 75vh; display: none; ">
            <div class="preloader" id="loader-temperatura2"></div>
        </div>
    </div>
</div>


<div class="col-12 col-xl-9 tab-second  grafica-temperatura" id="tab-informacion" style="margin-right: -5px !important; display:none !important;">
    <!-- Grafica -->
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card mt-3 p-3 ">
                <!-- <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="observaciones">Agregar Factor de correción:</label>
                            <input type="text" name="observaciones" value="" class="form-control input-form" required id="observaciones">
                            <input type="hidden" id="firma_guardar" name="firma" required />
                        </div>
                    </div>
                </div> -->

                <div class="table--container" style="width: fit-content;" id="grafica">

                </div>
            </div>
        </div>
    </div>
    <!-- Detalle grafica -->

</div>


<!-- Tercera Columna visual -->
<div id="reload-selectable">

</div>



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
                        <div class="col-12 col-lg-8">
                            <div id="content-comentarios-registros">

                                <div class="card m-3 p-3">
                                    <h5>Comentario creado por</h5>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo libero obcaecati necessitatibus doloremque. Incidunt ad, alias corrupti nihil est cupiditate rerum itaque illo consequuntur quis aliquid laboriosam possimus magnam ipsa.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
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
                <!-- <div class="d-flex justify-content-end">
                <button type="submit" form="TermometrosTemperaturasForm" class=" btn btn-confirmar" id="btn-equipo-temperatura">
                    <i class="bi bi-person-x"></i> Guardar
                </button>
            </div> -->


            </form>
            <button type="submit" form="ConfiguracionTemperaturaForm" class=" btn btn-confirmar" id="btn-configuracion-temperatura">
                <i class="bi bi-person-x"></i> Guardar
            </button>

        </div>
        <!-- <div class="dropdown mt-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Dropdown button
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div> -->
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