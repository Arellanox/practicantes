<div class="modal fade" id="ModalRegistrarEstudio" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header header-modal">
        <h5 class="modal-title" id="modal-title-estudios">Agregar Nuevo Estudio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="" id="formRegistrarEstudio">
          <p class="text-center">Rellene todos los datos necesarios para un nuevo <strong>Estudio</strong> </p>
          <div class="row">
            <!-- Información servicio -->
            <div class="col-4">
              <div class="card p-3">
                <div class="row">
                  <h5>Información del estudios</h5>
                  <p>Rellene la información basica del estudio</p>
                  <div class="col-8">
                    <label for="descripcion" class="form-label">Nombre del Estudio</label>
                    <input type="text" name="descripcion" class="form-control input-form" id="input-descripcion" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                  </div>
                  <div class="col-4">
                    <label for="abreviatura" class="form-label">CVE</label>
                    <input type="text" name="abreviatura" class="form-control input-form" id="input-abreviatura" data-bs-toggle="tooltip" data-bs-placement="top" title="Abreviatura que se visualizará en etiquetas si es necesario" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                  </div>
                  <!-- <div class="col-12 col-md-12">
                    <label for="grupo" class="form-label">Grupo de exámen</label>
                    <select name="grupo[]" multiple="multiple" id="registrar-grupo-estudio" required>
                    </select>
                  </div> -->
                  <!-- <div class="col-6 col-md-6">
                    <label for="area" class="form-label">Área</label>
                    <select name="area" id="registrar-area-estudio" required>
                    </select>
                  </div> -->
                  <div class="col-12 col-md-12">
                    <label for="clasificacion_id" class="form-label">Clasificación de exámen</label>
                    <select name="clasificacion_id" class="input-form" id="registrar-clasificacion-estudio" required>
                    </select>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="sin_clasificacion">
                      <label class="form-check-label" for="sin_clasificacion">
                        Sin clasificación
                      </label>
                    </div>
                  </div>
                  <!-- <div class="col-6 col-md-6">
                    <label for="metodo_id" class="form-label">Método</label>
                    <select name="metodo_id" id="registrar-metodos-estudio" required>
                    </select>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="sin_metodo">
                      <label class="form-check-label" for="sin_metodo">
                        Sin método
                      </label>
                    </div>
                  </div> -->
                  <div class="col-6 col-md-6">
                    <label for="medida_id" class="form-label">Medida</label>
                    <select name="medida_id" class="input-form" id="registrar-medidas-estudio">
                    </select>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="sin_medida">
                      <label class="form-check-label" for="sin_medida">
                        Sin medida
                      </label>
                    </div>
                  </div>
                  <div class="col-6 col-md-6">
                    <label for="dias_entrega" class="form-label">Día de entrega</label>
                    <input type="number" name="dias_entrega" class="input-form" id="input-dias_entrega">
                  </div>
                  <div class="col-12 col-md-12">
                    <label for="codigo_sat_id" class="form-label">Clave SAT</label>
                    <select name="codigo_sat_id" class="input-form" id="registrar-concepto-facturacion" required>
                    </select>
                  </div>
                  <div class="col-12 col-md-12">
                    <label for="indicaciones" class="form-label">Indicaciones</label>
                    <textarea class="md-textarea input-form" name="indicaciones" cols="45" rows="2" di="input-indicaciones"></textarea>
                  </div>
                  <div class="col-12">
                    <label for="es_para" class="form-label select-contenedor">Dirigido a:</label>
                    <select name="es_para" class="input-form" required="" id="input-dirigido-sexo-servicio">
                      <option value="3" selected>Todos</option>
                      <option value="1">Hombre</option>
                      <option value="2">Mujer</option>
                    </select>
                  </div>
                  <div class="row" style="zoom:100%;">
                    <div class="col-6">
                      <label for="">¿Se subroga?: </label>
                    </div>
                    <div class="col-3">
                      <input type="radio" name="local" id="registrar-subrogaSi" value="0" required>
                      <label for="registrar-subrogaSi">Si</label>
                    </div>
                    <div class="col-3">
                      <input type="radio" name="local" id="registrar-subrogaNo" value="1" required>
                      <label for="registrar-subrogaNo">No</label>
                    </div>
                  </div>
                  <div class="col-12 col-md-12" id="div-maquila" style="display:none">
                    <label for="maquila_lab_id" class="form-label">Prueba a maquilar: </label>
                    <select name="maquila_lab_id" class="input-form" id="maquila_agregar_estudio">
                    </select>
                  </div>

                </div>

              </div>
            </div>
            <!-- Información clasificación equipo /  -->
            <div class="col-4">
              <div class="card p-3">
                <div class="row">
                  <h5>Grupo de examen</h5>
                  <p>Seleccione o agregue los grupo de examen del estudio</p>
                  <div class="" id="div-select-grupo">
                    <div class="row">
                      <div class="col-12 col-lg-12 col-xxl-6">
                        <label for="grupo_examen[0][grupo_id]" class="form-label">Grupo</label>
                        <select name="grupo_examen[0][grupo_id]" class="input-form select-contenedor-Grupo" required=""></select>
                      </div>
                      <div class="col-12 col-lg-8 col-xxl-4">
                        <label for="grupo_examen[0][orden]" class="form-label">Posicion del grupo</label>
                        <input type="text" placerholder="Orden del servicio para el grupo" name="grupo_examen[0][orden]" required value="" class="form-control input-form">
                      </div>
                      <div class="col-2 d-flex justify-content-start align-items-center">
                        <button type="button" class="btn btn-hover eliminarContenerMuestra1" data-bs-contenedor="2" style="margin-top: 20px;">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="button" class="btn btn-hover" id="nuevo-select-grupo">
                        <i class="bi bi-plus"></i> Agregar
                      </button>
                    </div>
                  </div>


                  <div class="row mb-2" style="zoom:100%;">
                    <div class="col-6">
                      <label for="">¿Es un estudio o un grupo de estudios?</label>
                    </div>
                    <div class="col-3">
                      <input type="radio" name="grupos" id="registrar-grupoEstudio" value="0" required>
                      <label for="registrar-grupoEstudio">Estudio</label>
                    </div>
                    <div class="col-3">
                      <input type="radio" name="grupos" id="registrar-grupoGrupo" value="1" required>
                      <label for="registrar-grupoGrupo">Grupo</label>
                    </div>
                  </div>


                  <h5>Método</h5>
                  <p>Seleccione o agregue los metodos del estudio</p>
                  <div class="" id="div-select-metodo">
                    <div class="row">
                      <div class="col-10 col-md-10"><label for="Método[0]" class="form-label select-contenedor">Método</label>
                        <select name="Método[0]" class="input-form select-contenedor-Método">

                        </select>
                      </div>
                      <div class="col-2 d-flex justify-content-start align-items-center">
                        <button type="button" class="btn btn-hover eliminarContenerMuestra1" style="margin-top: 20px;">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="button" class="btn btn-hover" id="nuevo-select-metodo">
                        <i class="bi bi-plus"></i> Agregar
                      </button>
                    </div>
                  </div>

                  <h5>Muestra</h5>
                  <p>Seleccione los contenedores que necesite esté estudio</p>
                  <div class="" id="div-select-contenedores">
                    <div class="row">
                      <div class="col-5 col-md-5">
                        <label for="contenedores[2]" class="form-label select-contenedor">Contenedor</label>
                        <select name="contenedores[2][contenedor]" id="registrar-contenedor2-estudio" class="input-form" required="">
                          <option value="1">Frasco</option>
                          <option value="2">Tubo azul</option>
                          <option value="3">Tubo lila</option>
                          <option value="4">Tubo rojo</option>
                          <option value="5">Tubo negro</option>
                          <option value="6">Tubo verde</option>
                          <option value="7">Transcult</option>
                          <option value="8">TUBO AMARILLO</option>
                        </select>
                      </div>
                      <div class="col-5 col-md-5">
                        <label for="contenedores[2]" class="form-label select-contenedor">Tipo o muestra</label>
                        <select name="contenedores[2][muestra]" id="registrar-muestraCont2-estudio" class="input-form" required="" placeholder="Seleccione un contenedor">
                          <option value="1">EXPECTORACIÓN</option>
                          <option value="2">EXUDADO</option>
                          <option value="3">HECES</option>
                          <option value="4">LÍQUIDO</option>
                          <option value="5">ORINA</option>
                          <option value="6">SANGRE</option>
                          <option value="7">SEMEN</option>
                          <option value="8">UÑAS</option>
                        </select>
                      </div>
                      <div class="col-2 d-flex justify-content-start align-items-center"><button type="button" class="btn btn-hover eliminarContenerMuestra1" data-bs-contenedor="2" style="margin-top: 20px;"><i class="bi bi-trash"></i></button></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="button" class="btn btn-hover" id="nuevo-contenedor-muestra">
                        <i class="bi bi-plus"></i> Agregar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card p-3">
                <h5>Equipo de laboratorio</h5>
                <p>Seleccione o agregue los equipos del estudio</p>
                <div class="" id="div-select-equipo">
                  <div class="row">
                    <div class="col-10 col-md-10">
                      <label for="Equipo[0]" class="form-label select-contenedor">Equipo</label>
                      <select name="Equipo[0]" class="input-form select-contenedor-equipo">

                      </select>
                    </div>
                    <div class="col-2 d-flex justify-content-start align-items-center">
                      <button type="button" class="btn btn-hover eliminarContenerMuestra1" style="margin-top: 20px;">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <button type="button" class="btn btn-hover" id="nuevo-select-equipo">
                      <i class="bi bi-plus"></i> Agregar
                    </button>
                  </div>
                </div>
                <h5>Informacion Valores de referencia</h5>
                <p>Escriba el valor de referencia para el reporte...</p>
                <div class="row" style="zoom:100%;">
                  <div class="col-6">
                    <label for="">¿Mostrar valores de referencia? </label>
                  </div>
                  <div class="col-3">
                    <input type="radio" name="muestra_valores" id="registrar-varepoSi" value="1" checked required>
                    <label for="registrar-varepoSi">Si</label>
                  </div>
                  <div class="col-3">
                    <input type="radio" name="muestra_valores" id="registrar-varepoNo" value="0" required>
                    <label for="registrar-varepoNo">No</label>
                  </div>
                </div>
                <!-- <div id="super-nota">
                  <textarea id="summernote-estudios" name="editordata"></textarea>
                </div> -->
                <div class="row">
                  <div class="col-12">
                    <label for="valor_minimo" class="form-label">Valor minimo</label>
                    <textarea name="valor_minimo" class="input-form" rows="2" cols="20" id="valor_minimo_referencia"></textarea>
                  </div>
                  <div class="col-12">
                    <label for="valor_maximo" class="form-label">Valor maximo</label>
                    <textarea name="valor_maximo" class="input-form" rows="2" cols="20" id="valor_maximo_referencia"></textarea>
                  </div>
                  <div class="col-4">
                    <label for="sexo_enum" class="form-label select-contenedor">Dirigido a:</label>
                    <select name="sexo_enum" class="input-form" required="" id="input-dirigido-sexo-referencia">
                      <option value="3" selected>AMBOS</option>
                      <option value="1">HOMBRE</option>
                      <option value="2">MUJER</option>
                    </select>
                  </div>
                  <div class="col-4">
                    <label for="edad_inicial" class="form-label">Edad inicial:</label>
                    <input type="text" name="edad_inicial" class="form-control input-form" id="input-edad-inicial-referencia">
                  </div>
                  <div class="col-4">
                    <label for="edad_final" class="form-label">Edad final</label>
                    <input type="text" name="edad_final" class="form-control input-form" id="input-edad-final-referencia">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Cancelar</button>
        <button type="submit" form="formRegistrarEstudio" class="btn btn-confirmar" id="submit-registrarEstudio">
          <i class="bi bi-plus-square"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>
<script>
  formEstudios = $('#formRegistrarEstudio').html()
</script>