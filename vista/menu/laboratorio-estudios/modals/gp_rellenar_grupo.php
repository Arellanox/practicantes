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
                            <p>Pulse y arrastre el estudio para cargar su orden</p>
                            <table class="table display responsive" id="" style="width: 100%">

                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 p-3 mt-5">
                        <!-- <div class="p-3"> -->
                        <!-- <label for="fecha_final" class="form-label"></label> -->
                        <!-- </div> -->
                        <div class="">
                            <p>
                                Seleccion los estudios que desee agregar al grupo, y presione click en el boton de agregar, si desea devolver un estudio seleccione el grupo que desee devolver y presione el boton de desolver
                            </p>
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
                            <h5>Estudios</h5>
                            <p>Pulse y arrastre el estudio para cargar su orden</p>
                            <table class="table display responsive" id="TablaLLenarGrupo" style="width: 100%">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left-short"></i> Cancelar
                </button>
                <button type="button" id="btn-guardar-grupo" class="btn btn-confirmar">
                    <i class="bi bi-box-arrow-down"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>


<style>
    /* Estilo CSS para resaltar la fila durante el reordenamiento */
    .last-selected-row {
        background-color: #004e59 !important;
        color: red !important;
        /* Cambia el color a tu elección */
        transition: background-color 0.3s ease;
        /* Agrega una transición suave */
    }
</style>