<div class="modal fade" id="modalRellenarGrupos" tabindex="-1" aria-labelledby="filtrador" data-bs-focus="false" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title" id="title-grupo-factura">Rellenar Grupo: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-12 p-4">
                        <div class="card p-3">
                            <h5>Estudios</h5>
                            <p>Pulse en la primera columna y arrastre el estudio para cargar su orden, con el icono de <i class="bi bi-trash"></i> puedes eliminar el estudio de la tabla.</p>
                            <p class="none-p">No te olvides de guardar cambios.</p>
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