<div class="modal fade" id="ModalEditarGrupo" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header header-modal">
        <h5 class="modal-title" id="filtrador">Editar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="" id="formEditarGrupo">
          <p class="text-center">Editar Estudio Registrado <strong>Actualmente</strong> </p>
          <div class="row">
            <div class="col-4">
              <label for="nombre_estudio" class="form-label">Nombre del Estudio</label>
              <input type="text" name="nombre_estudio" id="edit-nombre-grupo" class="form-control input-form" required>
            </div>
            <div class="col-2">
              <label for="cve_estudio" class="form-label">CVE</label>
              <input type="text" name="cve_estudio" id="edit-cve-grupo" class="form-control input-form" required>
            </div>
            <div class="col-6 col-md-6">
              <label for="area" class="form-label">Área</label>
              <select name="area" id="edit-area-grupo">
              </select>
            </div>
            <div class="col-6 col-md-6">
              <label for="clasificacion" class="form-label">Clasificación de exámen</label>
              <select name="clasificacion" id="edit-clasificacion-grupo">
              </select>
            </div>
            <div class="col-6 col-md-6">
              <label for="metodo" class="form-label">Método</label>
              <select name="metodo" id="edit-metodos-grupo">
              </select>
            </div>
            <div class="col-3 col-md-3">
              <label for="medida" class="form-label">Medida</label>
              <select name="medida" id="edit-medidas-grupo">
              </select>
            </div>
            <div class="col-3 col-md-3">
              <label for="entrega" class="form-label">Día de entrega</label>
              <input type="number" name="entrega" class="input-form" value="" id="edit-dias-grupo" required>
            </div>
            <div class="col-6 col-md-6">
              <label for="confac" class="form-label">Concepto facturación</label>
              <select name="confac" id="edit-concepto-facturacion-grupo">
              </select>
            </div>
            <div class="col-6 col-md-6">
              <label for="indicaciones" class="form-label">Indicaciones</label>
              <br />
              <textarea class="md-textarea input-form" id="edit-indicaciones-grupo" name="indicaciones" cols="45" rows="2" placeholder=""></textarea>
            </div>
            <div class="row" style="zoom:100%;">
              <div class="col-6">
                <label for="">¿Mostrar valores de referencia? </label>
              </div>
              <div class="col-3">
                <input type="radio" name="varepo" value="1" id="edit-checkValSi-grupo" required>
                <label for="varepo">Si</label>
              </div>
              <div class="col-3">
                <input type="radio" name="varepo" value="0" id="edit-checkValNo-grupo" required>
                <label for="varepo">No</label>
              </div>
            </div>
            <div class="row" style="zoom:100%;">
              <div class="col-6">
                <label for="">Se subroga?: </label>
              </div>
              <div class="col-3">
                <input type="radio" name="subroga" value="1" required id="edit-checkRogSi-grupo">
                <label for="agre-subroga">Si</label>
              </div>
              <div class="col-3">
                <input type="radio" name="subroga" value="0" required id="edit-checkRogNo-grupo">
                <label for="agre-subroga">No</label>
              </div>
            </div>
            <p style="margin-top:15px; margin-bottom: 15px">Seleccione los contenedores que necesite esté estudio</p>
            <div class="" id="div-select-contenedoresGrupoEdit">

            </div>
            <div class="row">
              <div class="col-12">
                <button type="button" class="btn btn-hover" id="nuevo-contenedorGrupoEdit">
                  <i class="bi bi-plus"></i> Agregar nuevo contenedor
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Cancelar</button>
        <button type="submit" form="formEditarGrupo" class="btn btn-confirmar" id="submit-editarGrupo">
          <i class="bi bi-person-plus"></i> Crear
        </button>
      </div>
    </div>
  </div>
</div>
