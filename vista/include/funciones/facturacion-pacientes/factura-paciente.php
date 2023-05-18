<div class="modal fade" id="modalFacturaPaciente" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title">Factura: <strong id="nombre-paciente-factura"></strong></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Rellene todos los datos del formulario</p>
                <form class="row" id="formularioPacienteFactura">
                    <div class="col-12 col-lg-6">
                        <label for="razon_social" class="form-label">Razón social</label>
                        <input type="text" name="razon_social" value="" class="form-control input-form">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="domicilio" class="form-label">Domicilio fiscal</label>
                        <input type="text" name="domicilio" value="" class="form-control input-form">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="regimen_fiscal" class="form-label">Regimen fiscal</label>
                        <!-- <input type="text" name="domicilio" value="" class="form-control input-form"> -->
                        <select name="regimen_fiscal" id="regimen_fiscal-factura" class="input-form form-select"></select>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="rfc" class="form-label">RFC</label>
                        <input type="text" name="rfc" value="" class="form-control input-form" id="rfc-factura">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="uso" class="form-label">Uso</label>
                        <!-- <input type="text" name="domicilio" value="" class="form-control input-form"> -->
                        <select name="uso" id="uso-factura" class="input-form form-select"></select>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="metodo_pago" class="form-label">Método de pago</label>
                        <!-- <input type="text" name="domicilio" value="" class="form-control input-form"> -->
                        <select name="metodo_pago" class="input-form form-select">
                            <option>Seleccione un metodo de pago...</option>
                            <option value="1">PUE</option>
                            <option value="2">PDD</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="zoom:90%">
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left-short"></i> Cerrar
                </button>
                <button type="submit" form="formularioPacienteFactura" class="btn btn-pantone-7408">
                    <i class="bi bi-box-arrow-down"></i> Guardar y pagar
                </button>
            </div>
        </div>
    </div>
</div>