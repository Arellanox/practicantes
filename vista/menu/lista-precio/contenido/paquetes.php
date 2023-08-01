<div class="col-12 loader" id="loader" style="">
    <div class="preloader" id="preloader"> </div>
</div>

<div class="row" id="paq">

    <div class="card col-12 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 text-center">
                        <h4 class="pt-3">Seleccione la accion a realizar</h4>
                    </div>
                    <div class="col-auto">
                        <input type="radio" class="btn-check" name="selectPaquete" id="check-agregar" value="1" checked autocomplete="off">
                        <label class="btn btn-outline-success" for="check-agregar"><i class="bi bi-list"></i> Nuevo</label>
                    </div>
                    <div class="col-auto d-flex align-items-center d-flex justify-content-center">
                        <input type="radio" class="btn-check" name="selectPaquete" id="check-editar" value="2" autocomplete="off">
                        <label class="btn btn-outline-success" for="check-editar"><i class="bi bi-list"></i> Mantenimiento</label>
                    </div>
                </div>
                <div class="p-3" id="form-select-paquetes">
                    <div class="" id="selectDisabled">
                        <label for="inputBuscarPaquetes">Seleccione un paquete:</label>
                        <select name="seleccionpaquete" id="seleccion-paquete" class="input-form" required> </select>
                    </div>
                    <div class="row d-flex justify-content-center" style="margin-bottom: 15px">
                        <div class="col-auto">
                            <button class="btn btn-sm btn-confirmar" type="button" id="UsarPaquete"><i class="bi bi-binoculars"></i> Usar</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-borrar" type="button" id="CambiarPaquete" data-bs-toggle="tooltip" data-bs-placement="top" title="Borrará todo la tabla"><i class="bi bi-eraser"></i> Cambiar</button>
                        </div>
                    </div>
                    <div class="text-start formContenidoPaquete" id="formPaqueteBotonesArea" style="margin-top:4px;zoom:95%;margin-bottom:5px;">

                        <label for="inputBuscarPaquetes">Pulse el area del estudio:</label> <br>
                        <input type="radio" class="btn-check" name="selectChecko" id="check-img" value="11" autocomplete="off">
                        <label class="btn btn-outline-success" for="check-img"><i class="bi bi-list"></i>
                            Ultrasonido</label>

                        <input type="radio" class="btn-check" name="selectChecko" id="check-rx" value="8" autocomplete="off">
                        <label class="btn btn-outline-success" for="check-rx"><i class="bi bi-list"></i> Rayos X</label>

                        <input type="radio" class="btn-check" name="selectChecko" id="check-lab" value="6" autocomplete="off">
                        <label class="btn btn-outline-success" for="check-lab"><i class="bi bi-list"></i>
                            Laboratorio</label>

                        <input type="radio" class="btn-check" name="selectChecko" id="check-otros" value="0" autocomplete="off">
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
                            <button type="submit" form="formCompletarPaquete" class="btn btn-confirmar m-1" id="agregar-estudio-paquete">
                                <i class="bi bi-plus"></i> Agregar
                            </button>
                            <button type="submit" form="formCompletarPaquete" class="btn btn-borrar m-1" id="submit-cancelarPaquete" style="display:none">
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
                        <p>Subtotal Costo:</p>
                    </div>
                    <div class="col-6" id="subtotal-costo-paquete"></div>
                    <div class="col-6 text-end info-detalle">
                        <p>Subtotal precioventa:</p>
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
    <div class="card col-12 col-lg-9 pt-3" style="margin-bottom:5px;">
        <div class="col-12 d-flex align-items-center d-flex justify-content-center">
            <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="guardar-contenido-paquete">
                <i class="bi bi-save2"></i> Guardar paquete
            </button>
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Debes tener un paquete guardado previamente, utiliza el boton de 'Mantenimiento'">
                <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-excel-previa" disabled data-bs-toggle="modal" data-bs-target="#modalVistaPaquete">
                    <i class="bi bi-filetype-exe"></i> Excel (Vista previa)
                </button>
            </span>
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
                        <th scope="col d-flex justify-content-center" class="min-tablet">Subtotal</th>
                        <th scope="col d-flex justify-content-center" class="all">ID</th>
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