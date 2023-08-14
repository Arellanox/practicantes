<!-- Modal -->
<div class="modal fade" id="modalReferencia" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar valores de referencia</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
          <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-9 p-3">
                        <!-- Aqui va a ir la tabla -->
                        <table class="table table-hover display responsive " id="TablaListaPrecios" style="width: 100%">
                        <thead style="width: 100%">
                          <tr>
                            <th scope="col d-flex justify-content-center" class="all">#</th>
                            <th scope="col d-flex justify-content-center" class="all">Ab</th>
                            <th scope="col d-flex justify-content-center" class="all">Nombre</th>
                            <th scope="col d-flex justify-content-center" class="min-tablet">Costo</th>
                            <th scope="col d-flex justify-content-center" class="min-tablet">Margen</th>
                            <th scope="col d-flex justify-content-center" class="min-tablet">Total</th>
                          </tr> 
                        </thead>
                        <tbody id="contenido-lista-precios">
                            <tr>
                                <td> 1 </td>
                                <td> 1 </td>
                                <td> 1 </td>
                                <td> 1 </td>
                                <td> 1 </td>
                                <td> 1 </td>
                            </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="col-12 col-lg card shadow p-3">
                        <!-- El formulario para agregar referenciass -->
                    <h5>Información Valores de referencia</h5>
                    <p class="none-p">Escriba el valor de referencia para el reporte...</p>
                    <div class="row my-3">
                    <div class="col-12 col-lg-12">
                        <p>Dirigido a:</p>
                        <select class="form-select input-form" name="select-genero-referencia" id="select-genero-referencia">
                            <option selected>Elije una de las opciones disponibles</option>
                            <option value="">HOMBRE</option>
                            <option value="">MUJER</option>
                            <option value="">AMBOS</option>
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <p>Edad: </p>
                        <div class="input-group  mb-3">
                            <input type="number" class="form-control input-form" id="edad-minima-referencia" min="0" placeholder="Edad Minima">
                            <span class="input-span">-</span>
                            <input type="number" class="form-control input-form" id="edad-maxima-referencia" min="0" placeholder="Edad Maxima">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="SinEdad">
                            <label class="form-check-label" for="SinEdad">
                                Ignorar Edad
                            </label>
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
                    <div class="col-12">
                        <p>Presentacion:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                    <div class="col-12 col-lg-6">
                        <p>Valor Mínimo:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                    <div class="col-12 col-lg-6">
                        <p>Valor Maximo:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                </div>

                <div class="row" style="display: none;" id="resultado-select-rango">
                    <div class="col-12">
                        <p>Presentacion:</p>
                        <input type="text" class="form-control input-form" name="" id="">
                    </div>

                    <div class="col-12 col-lg-6">
                        <p>Resultado es:</p>
                        <select class="form-control input-form" name="select-genero-referencia">
                            <option value="">&#62; Mayor que</option>
                            <option value="">&#60; Menor que</option>
                            <option value="">&#61; Igual</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-6">
                        <p>Valor de referencia:</p>
                        <input type="text" class="form-control input-form" name="">
                    </div>
                </div>


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


<script>
    entrada = 20

    minimo = 60 // <=
    maximo = 20 //<

    if (entrada >= minimo && entrada <= maximo) {
        console.log("Esta entre el rango")
    } else if (entrada < minimo) {
        console.log("Es menor que el minimo")
    } else if (entrada > maximo) {
        console.log("Es mayor que el maximo")
    }
</script>