<div class="col-12 loader" id="loader">
    <div class=" preloader" id="preloader"> </div>
</div>

<div class="row" id="paq">

    <div class="col-3 card">
        <div class="row">
            <div class="col-12">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 text-center">
                        <h4 class="pt-3">Seleccione una acción</h4>
                    </div>
                    <div class="col-auto">
                        <input type="radio" class="btn-check" name="selectPaquete" id="check-agregar" value="1" checked
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="check-agregar"><i class="bi bi-list"></i>
                            Nuevo</label>
                    </div>
                    <div class="col-auto d-flex align-items-center d-flex justify-content-center">
                        <input type="radio" class="btn-check" name="selectPaquete" id="check-editar" value="2"
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="check-editar"><i class="bi bi-list"></i>
                            Mantenimiento</label>
                    </div>

                </div>
                <div class="p-3" id="form-select-paquetes">
                    <div class="" id="selectDisabled">
                        <label for="inputBuscarPaquetes">Busque un cliente:</label>
                        <select name="seleccionpaquete" id="seleccion-paquete" class="input-form" required
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Seleccione/Busque un cliente">
                        </select>
                        <div class="listaPresupuestos" id="container-select-presupuesto">
                            <label for="inputBuscarPaquetes">Busque un presupuesto:</label>
                            <select name="seleccionpaquete" id="select-presupuestos" class="input-form" required
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Seleccione/Busque un presupuesto ya guardado"> </select>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center" style="margin-bottom: 15px">
                        <div class="col-auto">
                            <button class="btn btn-sm btn-pantone-7408" type="button" id="UsarPaquete"><i
                                    class="bi bi-binoculars"></i> Usar</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-borrar" type="button" id="CambiarPaquete"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Borrará todo la tabla"><i
                                    class="bi bi-eraser"></i> Cambiar</button>
                        </div>
                    </div>



                    <div class="text-start formContenidoPaquete" id="formPaqueteBotonesArea"
                        style="margin-top:4px;zoom:95%;margin-bottom:5px;">

                        <label for="inputBuscarPaquetes">Pulse el area del estudio:</label> <br>
                        <input type="radio" class="btn-check" name="selectChecko" id="check-img" value="11"
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="check-img"><i class="bi bi-list"></i>
                            Ultrasonido</label>

                        <input type="radio" class="btn-check" name="selectChecko" id="check-rx" value="8"
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="check-rx"><i class="bi bi-list"></i> Rayos X</label>

                        <input type="radio" class="btn-check" name="selectChecko" id="check-lab" value="6"
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="check-lab"><i class="bi bi-list"></i>
                            Laboratorio</label>

                        <input type="radio" class="btn-check" name="selectChecko" id="check-otros" value="0"
                            autocomplete="off">
                        <label class="btn btn-outline-success" for="check-otros"><i class="bi bi-list"></i>Otros
                            Servicios</label>

                    </div>
                    <div class="row formContenidoPaquete" id="formPaqueteSelectEstudio">
                        <div class="col-12">
                            <label for="inputBuscarAreaEstudio">Lista de estudios por area:</label>
                            <select name="estudio" id="seleccion-estudio" class="input-form" required>
                            </select>
                        </div>
                        <div class="col-12 d-flex align-items-center d-flex justify-content-center">
                            <button type="submit" form="formCompletarPaquete" class="btn btn-pantone-7408 m-1"
                                id="agregar-estudio-paquete">
                                <i class="bi bi-plus"></i> Agregar
                            </button>
                            <button type="submit" form="formCompletarPaquete" class="btn btn-borrar m-1"
                                id="submit-cancelarPaquete" style="display:none">
                                <i class="bi bi-plus"></i> Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 pt-2" id="informacionPaquete">
                <div class="row">
                    <div class="col-12 text-center">
                        <h5>Calculo del paquete</h5>
                    </div>
                    <div class="col-6 text-end info-detalle">
                        <p>Subtotal (Costo):</p>
                    </div>
                    <div class="col-6" id="sin_descuento-subtotal-costo-paquete"></div>
                    <div class="col-6 text-end info-detalle">
                        <p>Subtotal (Precio Venta):</p>
                    </div>
                    <div class="col-6" id="sin_descuento-subtotal-precioventa-paquete"></div>
                    <div class="col-6 text-end info-detalle">
                        <p>IVA:</p>
                    </div>
                    <div class="col-6"> 16%</div>
                    <div class="col-6 text-end info-detalle">
                        <p>Total:</p>
                    </div>
                    <div class="col-6" id="sin_descuento-total-paquete"></div>

                    <div class="col-12">
                        <div class="input-group" style="padding: 0px 120px 0px 120px;">
                            <input type="number" class="form-control input-form text-center" name=""
                                placeholder="Descuento total %" id="descuento-paquete">
                            <span class="input-span">%</span>
                        </div>
                    </div>
                    <div class="row" style="display: none;" id="precios-con-descuento">
                        <!-- <div class="col-6 text-end info-detalle">
              <p>Subtotal (Costo):</p>
            </div>
            <div class="col-6" id="subtotal-costo-paquete"></div> -->
                        <div class="col-6 text-end info-detalle">
                            <p>Subtotal:</p>
                        </div>
                        <div class="col-6" id="subtotal-precioventa-paquete"></div>
                        <div class="col-6 text-end info-detalle">
                            <p>IVA:</p>
                        </div>
                        <div class="col-6"> 16%</div>
                        <div class="col-6 text-end info-detalle">
                            <p>Total:</p>
                        </div>
                        <div class="col-6" id="total-paquete"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card col-9 pt-3" style="margin-bottom:5px;">
        <div class="col-12 d-flex align-items-center d-flex justify-content-center">
            <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal"
                data-bs-target="#modalInfoDetalleCotizacion">
                <i class="bi bi-save2"></i> Guardar Cotización
            </button>
            <span data-bs-toggle="tooltip" data-bs-placement="top"
                title="Debes tener un paquete guardado previamente, utiliza el boton de 'Mantenimiento'">
                <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-excel-previa"
                    disabled data-bs-toggle="modal" data-bs-target="#modalVistaPaquete">
                    <i class="bi bi-filetype-exe"></i> Excel (Vista previa)
                </button>
            </span>

            <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-vistaPrevia-cotizacion">
                <i class="bi bi-file-earmark-pdf"></i> Cotización (Vista previa)
            </button>
        </div>

        <div id="tabla-Paquetes">
            <table class="table table-hover display responsive " id="TablaListaPaquetes" style="width: 100%">
                <thead style="width: 100%">
                    <tr>
                        <th scope="col d-flex justify-content-center" class="all">Descripción</th>
                        <th scope="col d-flex justify-content-center" class="all">CVE</th>
                        <th scope="col d-flex justify-content-center" class="min-tablet">Cantidad</th>
                        <th scope="col d-flex justify-content-center" class="min-tablet">Costo</th>
                        <th scope="col d-flex justify-content-center" class="min-tablet">Costo Total</th>
                        <th scope="col d-flex justify-content-center" class="min-tablet">Precio Venta</th>
                        <th scope="col d-flex justify-content-center" class="min-tablet">Descuento</th>
                        <th scope="col d-flex justify-content-center" class="min-tablet">Subtotal</th>
                        <th scope="col d-flex justify-content-center" class="all" style="display:none">ID</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<style media="screen">
.btn-outline-success {
    border-color: transparent;
}

.btn-outline-success:hover {
    opacity: 50%;
}
</style>