<!-- Modal -->
<div class="modal fade" id="modalReferencia" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
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
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <p>Dirigido a:</p>
                                <select class="form-control input-form" name="select-genero-referencia"
                                    id="select-genero-referencia">
                                    <option selected>Elija una opcion</option>
                                    <option value="HOMBRE">HOMBRE</option>
                                    <option value="MUJER">MUJER</option>
                                    <option value="AMBOS">AMBOS</option>
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <p>Edad:</p>
                                <div class="input-group">
                                    <input type="number" class="form-control input-form" id="edad-minima-referencia"
                                        min="0" placeholder="Edad Minima">
                                    <span class="input-span">-</span>
                                    <input type="number" class="form-control input-form" id="edad-maxima-referencia"
                                        min="0" placeholder="Edad Maxima">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <p>&nbsp;</p> <!-- Espacio en blanco para alinear con los inputs de edad -->
                                <div class="input-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="SinEdad">
                                        <label class="form-check-label" for="SinEdad">
                                            Ignorar Edad
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="cambioReferencia">
                    <label class="form-check-label" for="cambioReferencia">
                        Cambiar a referencia
                    </label>
                </div>

                <div class="row" id="cambio-rango-referencia">
                    <div class="col-3">
                        <p>Presentacion:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                    <div class="col-3">
                        <p>Valor Mínimo:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                    <div class="col-3">
                        <p>Valor Maximo:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                </div>

                <div class="row" style="display: none;" id="resultado-select-rango">
                    <div class="col-3">
                        <p>Presentacion:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                    <div class="col-3">
                        <p>Resultado es:</p>
                        <select class="form-control input-form" name="select-genero-referencia">
                            <option value="">&#62; Mayor que</option>
                            <option value="">&#60; Menor que</option>
                            <option value="">&#61; Igual</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <p>Valor de referencia:</p>
                        <input type="text" class="form-control input-form" name="">
                    </div>
                </div>

            </div>

            <div class="border rounded-top p-1 mx-3 my-1" id="vista-previa-presentacion">
                <p>Presentación</p>
                <h1>Hola</h1>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-pantone-7541" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-confirmar" id="btn-agregar-vista-previa"><i
                        class="bi bi-plus-circle"></i> Agregar</button>
                <button type="button" class="btn btn-confirmar">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
// entrada = 20

// minimo = 60 // <=
// maximo = 20 //<

// if (entrada >= minimo && entrada <= maximo) {
//     console.log("Esta entre el rango")
// } else if (entrada < minimo) {
//     console.log("Es menor que el minimo")
// } else if (entrada > maximo) {
//     console.log("Es mayor que el maximo")
// }
</script>