<div class="modal fade" id="ModalRegistrarPrueba" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title">Schedule new registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">



                <form id="formRegistrarAgenda">
                    <p class="text-center">

                        Use your
                        <strong>

                            CURP

                        </strong>

                        to create your laboratory record

                    </p>
                    <div class="row">
                        <div class="col-12 col-lg-8" id="Label-BuscarPaciente">
                            <label for="curp" class="form-label" id="label-identificacion">

                                curp

                            </label>
                            <input type="text" name="curp" value="" class="form-control input-form" id="curp-paciente" required="" style="text-transform: uppercase;" readonly="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkCurpPasaporte-agenda" disabled="">
                                <label class="form-check-label" for="checkCurpPasaporte-agenda">


                                    I'm a foreigner


                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4" style="margin-bottom: 10px;">
                            <label for="selectpaciente" class="form-label">

                                Find patient

                            </label>
                            <div class="row">
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-confirmar" type="button" id="actualizarForm"><i class="bi bi-binoculars"></i>

                                        Consult

                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-borrar" type="button" id="eliminarForm"><i class="bi bi-eraser"></i>

                                        Clean

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="formDIV">
                        <p id="mensaje" class="text-center">

                        </p>
                        <div class="row">
                            <div class="col-6">
                                <p>

                                    Patient:

                                </p>
                                <p id="paciente-registro">

                                    LUIS GERARDO CUEVAS GONZALEZ

                                </p>
                            </div>
                            <div class="col-6">
                                <p>

                                    CURP/Passport:

                                </p>
                                <p id="curp-registro">CUGL000622HTCVNSA5</p>
                            </div>
                            <div class="col-6">
                                <p>

                                    Sex:

                                </p>
                                <p id="sexo-registro">

                                    MALE

                                </p>
                            </div>
                            <div class="col-6">
                                <p>

                                    Origin

                                </p>
                                <div class="" id="procedencia-agenda">
                                    <p id="procedencia-registro">

                                        soup

                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="segmento" class="form-label">

                                    select segment

                                </label>
                                <select class="form-control input-form" id="selectSegmentos">
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="curp" class="form-label">

                                    schedule date

                                </label>
                                <input type="date" name="fechaAgenda" value="" class="form-control input-form" required="" id="fecha-agenda">
                            </div>
                        </div>
                        <br>
                        <div id="cuestionadioRegistro">
                            <h3>Questionnaire</h3>
                            <p class="none-p" style="margin-left: 10px" id="descripcion-antecedentes">


                                If it is your first registration, fill in each field of the questionnaire.
                                If you have had a previous registration, you can view your information and update them.
                                <br>


                                Click on each category of the questionnaire to display its fields.


                            </p>
                            <div class="mt-3" id="antecedentes-registro">

                            </div>
                        </div>

                        <!-- Cuestionario de espirometria -->
                        <div class="mt-3" id="formulario-espiro">

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer ">
                <!-- d-flex justify-content-between  -->
                <!-- <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
          <label class="form-check-label" for="flexCheckChecked">
            Checked checkbox
          </label>
        </div> -->
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i>

                    Cancel

                </button>
                <button type="submit" form="formRegistrarAgenda" class="btn btn-confirmar" id="btn-formregistrar-agenda">
                    <i class="bi bi-send-plus"></i>

                    to register


                </button>
            </div>
        </div>
    </div>
</div>