<div class="modal fade" id="modalExample" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-modal">
        <h5 class="modal-title" id="filtrador">Filtrar registros</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="" id="formRechazados">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
              <label for="procedencia" class="form-label">Procedencias</label>
              <select name="procedencia" id="procedencia" class="input-form">
                  <option value="1">Todos</option>

              </select>
            </div>
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <label for="segmentosFiltro" class="form-label">Segmento</label>
                <input type="text" name="" value="" class="input-form">
            </div>
              <!-- por definir filtro
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
              <label for="categoria" class="form-label">Categoria:</label>
              <select name="categoria" id="categoria" class="" autocomplete="off" required>
                <option value="1">Facturados</option>
                <option value="2">Sin facturar</option>
                <option value="3">Ambos</option>
              </select>
            </div>
            -->
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
              <label for="resultado" class="form-label">Resultado:</label>
              <select name="resultado" id="resultado" class="input-form" autocomplete="off" required>
                <option value="4">Todos los pacientes</option>
                <option value="3">Todos los pacientes con resultado</option>
                <option value="1">Solo positivos</option>
                <option value="2">Solo negativos</option>
              </select>
            </div>
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
              <label for="" class="form-label">Fecha inicial:</label>
              <input type="date" name="fechaInicial" id="fechaInicial" value="" class="input-form" required>
            </div>
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
              <label for="" class="form-label">Fecha final:</label>
              <input type="date" name="fechaFinal" id="fechaFinal" value="" class="input-form" required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Cancelar</button>
        <a class="btn btn-borrar" onclick="javascript:window.location.reload();"> Borrar filtro</a>
        <button type="submit" form="formRechazados" class="btn btn-confirmar">
          <i class="bi bi-list-columns-reverse"></i> filtrar
        </button>
      </div>
    </div>
  </div>
</div>
