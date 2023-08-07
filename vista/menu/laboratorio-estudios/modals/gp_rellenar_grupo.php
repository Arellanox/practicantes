<div class="modal fade" id="modalRellenarGrupos" tabindex="-1" aria-labelledby="filtrador" data-bs-focus="false" aria-hidden="true">
    <div class="modal-dialog  modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title" id="title-grupo-factura">Rellenar Grupo: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-lg-4 p-4">
                        <div class="card p-3">
                            <h5>Estudios</h5>
                            <table class="table display responsive" id="TablaFiltradaCredito" style="width: 100%">

                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 p-3 mt-5">
                        <div class="">
                            <div class="row mt-3">
                                <div class="col-12 mt-3 d-flex justify-content-center">
                                    <button class="btn btn-success" style="padding:12px 26px" id="AgregarPacientesGrupo">
                                        Agregar <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                                <div class="col-12 mt-3 d-flex justify-content-center">
                                    <button class="btn btn-turquesa" style="padding:12px 26px" id="QuitarPacientesGrupo">
                                        <i class="bi bi-arrow-left"></i> Devolver
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 p-4">
                        <div class="card p-3">
                            <h5>Estudios a agregar</h5>
                            <table class="table display responsive" id="TablaPacientesNewGrupo" style="width: 100%">

                            </table>
                        </div>
                    </div>

                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left-short"></i> Cerrar
                </button>
                <button type="button" id="btn-guardar-grupo" class="btn btn-confirmar">
                    <i class="bi bi-box-arrow-down"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>