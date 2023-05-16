<div class="modal fade" id="modalEstudiosContado" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title">Detalle del paciente <strong id="nombre-paciente-contado"></strong></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6" id="container-estudios-11">
                        <div class="card m-1 p-3">
                            <h5>Ultrasonido</h5>
                            <!-- 11 -->
                            <table class="table table-hover" id="">
                                <thead class="">
                                    <tr>
                                        <th scope="d-flex justify-content-center" class="col-6">Servicio</th>
                                        <th scope="d-flex justify-content-center" class="col-2">Cantidad</th>
                                        <th scope="d-flex justify-content-center" class="col-4">Precio antes de IVA</th>
                                    </tr>
                                </thead>
                                <tbody id="cargos-estudios-11">
                                    <tr>
                                        <th>${element['DESCRIPCION']}</th>
                                        <td>${element['CANTIDAD']}</td>
                                        <td>${element['PRECIO_VENTA']}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-6" id="container-estudios-6">
                        <div class="card m-1 p-3">

                            <h5>Laboratorio</h5>
                            <!-- 6 -->
                            <table class="table table-hover" id="">
                                <thead class="">
                                    <tr>
                                        <th scope="d-flex justify-content-center" class="col-6">Servicio</th>
                                        <th scope="d-flex justify-content-center" class="col-2">Cantidad</th>
                                        <th scope="d-flex justify-content-center" class="col-4">Precio antes de IVA</th>
                                    </tr>
                                </thead>
                                <tbody id="cargos-estudios-6">
                                    <tr>
                                        <th>${element['DESCRIPCION']}</th>
                                        <td>${element['CANTIDAD']}</td>
                                        <td>${element['PRECIO_VENTA']}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-6" id="container-estudios-8">
                        <div class="card m-1 p-3">

                            <h5>Rayos X</h5>
                            <!-- 8 -->
                            <table class="table table-hover" id="">
                                <thead class="">
                                    <tr>
                                        <th scope="d-flex justify-content-center" class="col-6">Servicio</th>
                                        <th scope="d-flex justify-content-center" class="col-2">Cantidad</th>
                                        <th scope="d-flex justify-content-center" class="col-4">Precio antes de IVA</th>
                                    </tr>
                                </thead>
                                <tbody id="cargos-estudios-11">
                                    <tr>
                                        <th>${element['DESCRIPCION']}</th>
                                        <td>${element['CANTIDAD']}</td>
                                        <td>${element['PRECIO_VENTA']}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-6" id="container-estudios-0">
                        <div class="card m-1 p-3">

                            <h5>Otros estudios</h5>
                            <!-- 0 -->
                            <table class="table table-hover" id="">
                                <thead class="">
                                    <tr>
                                        <th scope="d-flex justify-content-center" class="col-6">Servicio</th>
                                        <th scope="d-flex justify-content-center" class="col-2">Cantidad</th>
                                        <th scope="d-flex justify-content-center" class="col-4">Precio antes de IVA</th>
                                    </tr>
                                </thead>
                                <tbody id="cargos-estudios-0">
                                    <tr>
                                        <th>${element['DESCRIPCION']}</th>
                                        <td>${element['CANTIDAD']}</td>
                                        <td>${element['PRECIO_VENTA']}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-12 d-flex justify-content-end mt-4">
                        <div class="row">
                            <div class="col-8 text-end">Total de cargos:</div>
                            <div class="col-4 text-start" id="precio-total-cargo"> $0<!-- calculo --></div>
                            <div class="col-8 text-end">#% de descuento:</div>
                            <div class="col-4 text-start" id="precio-descuento"> $0<!-- calculo --></div>
                            <div class="col-8 text-end">Subtotal:</div>
                            <div class="col-4 text-start" id="precio-subtotal"> $0<!-- calculo --></div>
                            <div class="col-8 text-end">IVA:</div>
                            <div class="col-4 text-start" id="precio-iva"> $0<!-- calculo --></div>
                            <div class="col-8 text-end">Total:</div>
                            <div class="col-4 text-start" id="precio-total"> $0<!-- calculo --></div>
                        </div>
                    </div>



                </div>

            </div>
            <div class="modal-footer" style="zoom:90%">
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left-short"></i> Cerrar
                </button>
                <button type="button" class="btn btn-pantone-7408" data-bs-dismiss="modal" id="terminar-proceso-cargo">
                    <i class="bi bi-box-arrow-down"></i> Guardar y pagar
                </button>
            </div>
        </div>
    </div>
</div>