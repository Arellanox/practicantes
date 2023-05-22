<?php
$form = $_POST['form'];

?>
<!-- <div class="col-12 loader" id="loader" style="">
  <div class="preloader" id="preloader"> </div>
</div> -->
<!-- <div class="row">
  <div class="card col-12 col-lg-3 pt-4">
    <div class="" id="panel-informacion">

    </div>
    <div class="" id="panel-resultadosMaster">

    </div>
  </div>
  <div class="card col-12 col-lg-9" style="margin-bottom:5px">
    <div class="text-center" style="margin-top:4px;zoom:95%;margin-bottom:5px;">
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-analisis-pdf">
        <i class="bi bi-clipboard2-plus"></i> Subir interpretación
      </button>
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-capturas-pdf">
        <i class="bi bi-clipboard2-plus"></i> Guardar capturas
      </button>
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-analisis-oftalmo">
        <i class="bi bi-clipboard2-plus"></i> Subir resultados 2
      </button>
    </div>
    <table class="table table-hover display responsive tableContenido" id="TablaContenidoResultados" style="width: 100%">
      <thead class="" style="width: 100%">
        <tr>
          <th scope="col d-flex justify-content-center" class="all">#</th>
          <th scope="col d-flex justify-content-center" class="all">Nombre</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Prefolio</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Procedencia</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Edad</th>
          <th scope="col d-flex justify-content-center" class="min-tablet">Sexo</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div> -->


<div class="col-12 loader" id="loader">
  <div class="preloader" id="preloader"> </div>
</div>
<div class="row">
  <div class="col-3 col-lg-3" style="margin-right: -5px !important;">
    <div class="card mt-3 p-3" id="lista-pacientes">
      <h4>Lista de pacientes</h4>
      <div class="text-center">
        <label for="inputBuscarTableListaNuevos">Buscar:</label>
        <input type="text" class="form-control input-color" style="display: unset !important;width:auto !important" name="inputBuscarTableListaPacientes" value="" style="width:80%" autocomplete="off" id="BuscarTablaListaMuestras">
      </div>
      <table class="table table-hover display responsive tableContenido" id="TablaContenidoResultados" style="width: 100%">
        <thead class="" style="width: 100%">
          <tr>
            <th scope="col d-flex justify-content-center" class="all">#</th>
            <th scope="col d-flex justify-content-center" class="all">Nombre</th>
            <th scope="col d-flex justify-content-center" class="min-tablet">Prefolio</th>
            <th scope="col d-flex justify-content-center" class="none">Cliente</th>
            <th scope="col d-flex justify-content-center" class="none">Segmento</th>
            <th scope="col d-flex justify-content-center" class="none">Turno</th>
            <th scope="col d-flex justify-content-center" class="none">Sexo</th>
            <th scope="col d-flex justify-content-center" class="none">Expendiente</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-3 col-lg-3 informacion-paciente" style="margin-right: -5px !important;display:none">
    <div class="card m-3" id="panel-informacion"> </div>
    <div class="" id="panel-resultadosMaster"> </div>
    <!-- <div class="card m-3 p-4">
      <h4>Estudios anteriores</h4>
      <div class="accordion" id="accordionResultadosAnteriores">
      </div>
    </div> -->
  </div>
  <div class="col-lg-6 informacion-paciente" style="margin-right: -5px !important;display:none">
    <div class="card mt-3 p-3">
      <div class="row">
        <div class="col-12 col-lg-7">
          <h4>Reporte de interpretación</h4>
          <p class="none-p"></p>
        </div>
        <div class="row">
          <div class="col-6 text-start" style="margin-top:4px;margin-bottom:5px;">
            <button type="button" class="btn btn-hover me-2 btnResultados" style="margin-bottom:4px" id="btn-capturas-pdf">
              <i class="bi bi-clipboard2-plus"></i> Cargar capturas
            </button>
          </div>
          <div class="col-6 text-end" style="margin-top:4px;margin-bottom:5px;">
            <button type="button" class="btn btn-confirmar me-2 btnResultados" style="margin-bottom:4px" id="btn-analisis-pdf">
              <i class="bi bi-clipboard2-plus"></i> Guardar reporte
            </button>


            <!-- SubmitPorAreas -->
            <button type="submit" form="formSubirInterpretacionOftalmo" class="btn btn-confirmar me-2 btnResultados" style="margin-bottom:4px" id="btn-analisis-oftalmo">
              <i class="bi bi-clipboard2-plus"></i> Guardar Reporte
              <!-- formulario para oftamologia -->
            </button>
            <button type="submit" form="formSubirInterpretacion" class="btn btn-confirmar me-2 btnResultados" style="margin-bottom:4px" id="btn-analisis">
              <i class="bi bi-clipboard2-plus"></i> Subir Reporte
              <!-- BTN para formulario global -->
            </button>

            <button type="submit" data-attribute="confirmar" class="btn btn-hover" id="omitir-paciente" style="margin-bottom:4px">

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">

          <?php
          switch ($form) {
              //<!-- Resultados de oftalmologia -->
            case 'formSubirInterpretacionOftalmo':
              echo '<form id="formSubirInterpretacionOftalmo" class="overflow-auto" style="display:none;max-width: 100%; max-height: 68vh;margin-bottom:10px; padding: 15px;">';
              include 'forms/oftalmo.html';
              echo '</form>';
              break;

              //<!-- Formulario general -->
            case 'formSubirInterpretacion':
              echo '<form id="formSubirInterpretacion" class="overflow-auto" style="display:none;max-width: 100%; max-height: 68vh;margin-bottom:10px; padding: 15px;">';
              include 'forms/form_general.html';
              echo '</form>';
              break;
          }

          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-9 d-flex justify-content-center align-items-center" id='loaderDivPaciente' style="max-height: 75vh; display:none">
    <div class="preloader" id="loader-paciente"></div>
  </div>
</div>

<div>
  <div class="modal fade" id="modalPacienteAceptar" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-xxl-down modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header header-modal">
          <h5 class="modal-title" id="title-paciente_aceptar">Nombre paciente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer" style="zoom:90%">
          <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Cerrar</button>
          <button type="button" class="btn btn-cancelar" id="siguienteForm"><i class="bi bi-arrow-right-circle"></i> Siguiente</button>
          <button type="submit" form="formAceptarPacienteRecepcion" class="btn btn-confirmar" id="btn-confirmar-paciente">
            <i class="bi bi-check2-square"></i> Aceptar paciente
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  #TablaContenidoResultados_filter {
    display: none
  }
</style>