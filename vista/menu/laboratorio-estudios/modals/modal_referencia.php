<!-- Modal -->
<div class="modal fade" id="modalReferencia" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar valores de referencia</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <hr>
                <h5>Información Valores de referencia</h5>
                <p class="none-p">Escriba el valor de referencia para el reporte...</p>
                <div class="row my-3">
                    <div class="col-12 col-lg-6">
                        <p>Dirigido a:</p>
                        <select class="form-select input-form" name="select-genero-referencia" id="select-genero-referencia">
                            <option value="">HOMBRE</option>
                            <option value="">MUJER</option>
                            <option value="">AMBOS</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <p>Edad: </p>
                        <div class="input-group  mb-3">
                            <input type="text" class="form-control input-form" placeholder="Edad Minima" aria-label="Username">
                            <span class="input-span">-</span>
                            <input type="text" class="form-control input-form" placeholder="Edad Maxima" aria-label="Server">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="SinEdad">
                            <label class="form-check-label" for="SinEdad">
                                Ignorar Edad
                            </label>
                        </div>

                        <!-- <input type="number" id="number" name="number" placeholder='Edad Minima' class="form-input input-form" min='0'> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-1">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-pantone-7541" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-confirmar">Guardar</button>
            </div>
        </div>
    </div>
</div>